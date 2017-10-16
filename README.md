# Recruitment task

This script / project simply parses either XML, Yaml or CSV data in a fixed format, and allows simple totalisation or averaging of the data found therein

## Configurability
You can configure with command line switches to generate on-screen display
- Which file to load *--filename=*
- Which format the file is in (Autodiscovery is a TODO) *--filetype=*
- Which column in the data to apply the maths to *--field=*
- Which maths to load *--action=*
- What form of output to use *--output=* Note that currently only screen output is functional

## Requirements
- PHP 7.1 +
- composer
- Lib MBstring

## Over-Engineered? 
Absolutely

## Usage examples

`php Scripts/do.php --action=summarise --filetype=yaml --filename="data/file.yml" --field=value --output=screen`

`php Scripts/do.php --action=average --filetype=xml --filename="data/file2.xml" --field=length --output=file`