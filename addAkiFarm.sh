#!/bin/sh
find . -type f | xargs sed -i 's/http:\/\/localhost/http:\/\/localhost\/aki_farm/g'
