#!/bin/sh
find . -type f | xargs sed -i 's/http:\/\/localhost/http:\/\/localhost\/aki_farm/g'
find . -type f | xargs sed -i 's/\"class\//\"..\/..\/class\/reserve\//g'
find . -type f | xargs sed -i 's/\".\/class\//\"..\/..\/class\/reserve\//g'
find . -type f | xargs sed -i 's/\"js\//\"..\/..\/js\//g'
find . -type f | xargs sed -i 's/\"css\//\"..\/..\/css\//g'
find . -type f | xargs sed -i 's/.\/common\//..\/..\/html\/common\//g'
find . -type f | xargs sed -i 's/.href = \".\/AMP.php\"/.href = \"..\/..\/html\/course\/list.php\"/g'
find . -type f | xargs sed -i 's/src=\"lib\/jquery/src=\"..\/..\/js\/lib\/jquery/g'
