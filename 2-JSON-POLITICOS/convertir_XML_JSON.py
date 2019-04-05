#!/usr/bin/python
# coding: utf-8

import json
import xmltodict

with open("Desktop/XML/politico.xml", 'r', encoding = "UTF8") as f:
    xmlString = f.read()

jsonString = json.dumps(xmltodict.parse(xmlString), indent=4, ensure_ascii=False)
 
print("\nJSON output(politico.json):")
print(jsonString)
 
with open("Desktop/XML/politico.json", 'w') as f:
f.write(jsonString)
