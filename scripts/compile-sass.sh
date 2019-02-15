#!/bin/bash

cd ../assets/sass
pwd
echo "Compilando SASS do plugin AcolheSUS ..."

if [ "$1" == "w" ]
then
    echo "Observando alterações no código ..."
    sass --watch index.scss:../css/acolhesus.css
else
	sass index.scss:../css/acolhesus.css
	echo "...Pronto!"
fi