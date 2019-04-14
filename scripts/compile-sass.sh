#!/bin/bash

cd ../assets/sass
echo "Compilando saas do plugin AcolheSUS a partir de:"
pwd

if [ "$1" == "w" ]
then
    echo "Observando alterações no código ..."
    sass --watch index.scss:../css/acolhesus.css
else
	sass index.scss:../css/acolhesus.css
	echo "...Pronto!"
fi