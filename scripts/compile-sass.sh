#!/bin/bash

cd ../assets/sass
pwd
echo "Compilando SASS do plugin AcolheSUS ..."
sass index.scss:../css/acolhesus.css
echo "...Pronto!"