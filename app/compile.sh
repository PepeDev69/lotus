#! /bin/bash

echo "Compiling Nuxt"
rm -rf node_modules/.cache nuxt

npm cache clean -f
npm run build