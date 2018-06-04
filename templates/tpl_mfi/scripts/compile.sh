#!/bin/sh

rm ../css/template.* 2> /dev/null
sass ../scss/template.scss ../css/template.css
yui-compressor -o ../css/template.min.css ../css/template.css

rm ../css/chosen.* 2> /dev/null
sass ../scss/chosen.scss ../css/chosen.css
yui-compressor -o ../css/chosen.min.css ../css/chosen.css

rm ../css/bootstrap.* 2> /dev/null
sass ../scss/bootstrap.scss ../css/bootstrap.css
yui-compressor -o ../css/bootstrap.min.css ../css/bootstrap.css
