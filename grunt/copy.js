// Copy files to the 'build' folder
module.exports = {
    dist: {
        expand: true,
        nocase: true,
        cwd: '<%= config.root %>',
        src: ['**', '!**/sass/**', '!**/source/**', '!**/vendor/**', '!**/_*.*', '!.ds_store', '!thumbs.db'],
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
