mkdir -p public/styles
mkdir -p public/scripts
sass styles/index.scss public/styles/index.css --style compressed
esbuild src/index.js --bundle --sourcemap --target=chrome58,firefox57,safari11,edge16 --outfile=public/scripts/app.js