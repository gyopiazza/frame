// Copy files to the 'build' folder
module.exports = {
    build: {
        expand: true,
        nocase: true,
        cwd: '<%= config.root %>',
        src: ['**', '!**/_*.*', '!**/source/**', '!**/autoload/**', '!**/*.css.map', '!**/*.map', '!.ds_store', '!thumbs.db'],
        dest: '<%= config.build %><%= package.name %>'
    },
    dev: {
        expand: true,
        nocase: true,
        cwd: '<%= config.root %>',
        src: ['**', '!.ds_store', '!thumbs.db'],
        dest: '<%= config.build %><%= package.name %>'
    }
};
