Instalation
===========
git remote add commerce https://github.com/griga/yii-commerce-draft<br>
git fetch<br>
git pull commerce master<br>
git push<br>

Submodules
----------------
git submodule add https://github.com/griga/yii-commerce-components protected/components<br>
git submodule add https://github.com/griga/yii-common-theme-files themes/common<br>
git submodule add https://github.com/griga/yii-commerce-theme themes/commerce<br>
git submodule add https://github.com/griga/yii-ext-yg protected/extensions/yg<br>
git submodule add https://github.com/griga/yii-module-catalog protected/modules/catalog<br>
git submodule add https://github.com/griga/yii-module-content protected/modules/content<br>
git submodule add https://github.com/griga/yii-module-seo protected/modules/seo<br>
git submodule add https://github.com/griga/yii-module-sys protected/modules/sys<br>
git submodule add https://github.com/griga/yii-module-translation protected/modules/translation<br>
git submodule add https://github.com/griga/yii-module-upload protected/modules/upload<br>
git submodule add https://github.com/griga/yii-module-user protected/modules/user<br>

Composer dependencies
-----------------------------------
cd protected
composer init --prefer-dist --profile -v