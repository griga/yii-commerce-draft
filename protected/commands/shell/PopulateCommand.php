<?php
/** Created by griga at 02.07.2014 | 14:44.
 * 
 */


require_once __DIR__.'/../../extensions/simple_html_dom.php';

class PopulateCommand extends CConsoleCommand {

    const ROOT_URL = 'http://www.allprojectors.com.ua/';
    public function run($args)
    {
        $this->cleanUp();

        $categoriesData = [
            ['id'=>1, 'name'=>'Бюджетные', 'subcategories'=>[]],
            ['id'=>2, 'name'=>'Ультрапортативные', 'subcategories'=>[]],
            ['id'=>3, 'name'=>'Портативные', 'subcategories'=>[]],
            ['id'=>4, 'name'=>'Инсталляционные', 'subcategories'=>[]],
            ['id'=>5, 'name'=>'Кинотеатральные', 'subcategories'=>[]],
            ['id'=>6, 'name'=>'Экраны', 'subcategories'=>[]],
            ['id'=>7, 'name'=>'Интерактивные доски', 'subcategories'=>[]],
            ['id'=>9, 'name'=>'HD медиаплееры', 'subcategories'=>[]],
        ];

        foreach ($categoriesData as &$categoryData) {
            $resp = self::curlGet(self::ROOT_URL . 'category.php?intCategoryID='.$categoryData['id']);

            foreach (['/<div class="brands1">.+?<\/div>/si','/<div class="brands2">.+?<\/div>/si'] as $categoryBrandPattern ) {
                preg_match($categoryBrandPattern, $resp, $matches);
                if (count($matches)) {
                    $categoryBrandsHtml = str_get_html($matches[0]);
                    foreach ($categoryBrandsHtml->find('a') as $brandLink) {
                        $categoryData['subcategories'][] = [
                            'url' => $brandLink->href,
                            'name' => $brandLink->innertext,
                        ];
                    }
                }
            }
        }

        foreach($categoriesData as $categoryData){

            $rootCategory = new ProductCategory();
            $rootCategory->name = $categoryData['name'];
            $rootCategory->enabled = 1;
            $rootCategory->save();
            var_dump($categoryData['subcategories']);
            foreach($categoryData['subcategories'] as $subCategoryData){
                $subCategory = new ProductCategory();
                $subCategory->name = $subCategoryData['name'];
                $subCategory->enabled = 1;
                $subCategory->parent_id = $rootCategory->id;
                $subCategory->save();
                $manufacturer = self::getManufacturer($subCategory->name);

                $categoryRawHtml = self::curlGet(self::ROOT_URL . $subCategoryData['url']);

                preg_match_all('/<h3>.+?href="(.+?)".+?<\/h3>/si',$categoryRawHtml, $matches);

                foreach($matches[1] as $productUrl){
                    $productRawHtml = iconv("Windows-1251","UTF-8",self::curlGet(self::ROOT_URL . $productUrl));
                    preg_match('/<h3>.+?<nobr>(.+?)<\/nobr>.+?<\/h3>/si',$productRawHtml, $productMatches);
                    $productName = $productMatches[1];
                    preg_match('/<p class="price">\$(.+?)<\/p>/si',$productRawHtml, $productMatches);
                    $productPrice = $productMatches[1];
                    preg_match('/<p class="descr">(.+?)<\/p>/si',$productRawHtml, $productMatches);
                    $productDescr = $productMatches[1];
                    preg_match('/<div class="content">(.+?)<\/div>/si',$productRawHtml, $productMatches);
                    $productContent = trim($productMatches[1]);
                    preg_match('/<img src=".+?" border="0" hspace="16" vspace="15" width="148" style="cursor:pointer;" onclick="javascript:onOpenWindow\(\'.+?productImg\/(.+?)\'\)">/si',$productRawHtml, $productMatches);
                    $imageUrl = $productMatches[1];

                    file_put_contents(self::getResourcePath() . '/temp.jpg', fopen(self::ROOT_URL . 'templates/filestorage/productImg/'. rawurlencode($imageUrl), 'r'));

                    $fileName = md5(''.time()).'.jpg';
                    $fileUrl = '/images/products/'.$fileName;

                    copy(self::getResourcePath() . '/temp.jpg', __DIR__.'/../../../'.$fileUrl);
                    UploadService::createCopyToDataRoot('/'.$fileUrl);
                    $dataroot = Yii::app()->params['dataDir'];

                    $datadir= dirname($dataroot.'/'.$fileUrl);
                    if (!is_dir($datadir)) {
                        mkdir($datadir, 0755, true);
                    }
                    copy(self::getResourcePath() . '/temp.jpg' , $dataroot . '/'.$fileUrl);

                    $upload = new Upload();
                    $upload->entity = 'Product';
                    $upload->filename = $fileUrl;
                    $upload->user_id = 1;
                    $upload->entity_id = 0;
                    $upload->save();

                    $product = new Product();
                    $product->name = $productName;
                    $product->price = $productPrice;
                    $product->short_content = $productDescr;
                    $product->content = $productContent;
                    $product->category_id = $subCategory->id;
                    $product->manufacturer_id = $manufacturer->id;
                    $product->enabled = 1;
                    $product->image_id = $upload->id;
                    $product->save();

                    db()->createCommand()->update('{{upload}}',[
                        'entity_id'=>$product->id
                    ], 'id='.$upload->id);

                    var_dump($productUrl);
                }

//                file_put_contents(self::getResourcePath() . '/test.html', $categoryRawHtml);

//                die();

            }

        }

//        file_put_contents(self::getResourcePath().'/test.html',$resp);
//        $rootDom = str_get_html($resp);
//        $categoryWrapper = $rootDom->find('body>table>tbody>tr',1);
//        var_dump(count($categoryWrapper->find('td[width="34%"]')));
//        var_dump(count($categoryWrapper->find('td[width="66%"]')));
    }

    public function cleanUp(){
        ProductCategory::model()->deleteAll();
        Manufacturer::model()->deleteAll();
        Upload::model()->deleteAll('entity="Product"');
        Product::model()->deleteAll();
    }

    public static $manufacturers = [];
    public static function getManufacturer($name){
        $alias = StringHelper::generateAlias($name);
        if(!isset(self::$manufacturers[$alias])){
            $manufacturer = new Manufacturer();
            $manufacturer->name = $name;
            $manufacturer->save();
            self::$manufacturers[$alias] = $manufacturer;
        }
        return self::$manufacturers[$alias];



    }

    public static function getResourcePath()
    {
        $path = app()->getRuntimePath() . '/populate';
        if(!is_dir($path))
            mkdir($path,0755,true);
        return $path;
    }

    public static function curlGet($url)
    {
        $ch = curl_init();
        $cookie_file = self::getResourcePath() . 'cookie.txt';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//        curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888'); //  enables fiddler inspect
//        curl_setopt($ch, CURLOPT_HEADER, true);
//        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//        curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12');
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        } else {
            curl_close($ch);
            return $response;
        }
    }
} 