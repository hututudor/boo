mkdir -p public/scripts
esbuild src/index.js --bundle --sourcemap --target=chrome58,firefox57,safari11,edge16 --outfile=public/scripts/app.js --watch