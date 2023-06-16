mkdir -p ../server/public/scripts
esbuild src/index.js --bundle --minify --sourcemap --target=es6 --outfile=../server/public/scripts/app.js --watch