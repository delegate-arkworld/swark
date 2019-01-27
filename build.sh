#!/usr/bin/env bash

commit=$1
if [ -z ${commit} ]; then
    commit=$(git tag | tail -n 1)
    if [ -z ${commit} ]; then
        commit="master";
    fi
fi

# Remove old release
rm -rf Swark Swark-*.zip

# Build new release
mkdir -p Swark
git archive ${commit} | tar -x -C Swark
composer install --no-dev -n -o -d Swark
zip -x "*build.sh*" -x "*.MD" -r Swark-${commit}.zip Swark