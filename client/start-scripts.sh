mkdir -p public/scripts
esbuild src/index.js --bundle --minify --sourcemap --target=es6 --outfile=public/scripts/app.js --watch