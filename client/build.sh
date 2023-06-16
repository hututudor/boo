mkdir -p public/styles
mkdir -p public/scripts
sass styles/index.scss ../server/public/styles/index.css --style compressed
esbuild src/index.js --bundle --minify --sourcemap --target=es6 --outfile=../server/public/scripts/app.js