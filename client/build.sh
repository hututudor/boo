# copy html
mkdir -p build
cp -r src/pages/* build

# copy js
mkdir -p build/scripts
cp -r src/scripts/* build/scripts

# copy assets
mkdir -p build/assets
cp -r src/assets/* build/assets

# build sass files
mkdir -p build/styles
sass src/style/pages/auth.scss build/styles/auth.css --style compressed