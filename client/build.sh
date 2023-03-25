# copy html
mkdir -p build
cp -r src/pages/* build

# copy js
mkdir -p build/scripts
cp -r src/scripts/* build/scripts

# build sass files
mkdir -p build/styles
sass src/style/pages/auth.scss build/styles/auth.css