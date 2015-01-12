// Copy files to the 'build' folder
module.exports = {
    dist: {
        expand: true,
        cwd: '<%= config.root %>',
        src: ['**', '!**/sass/**', '!**/source/**', '!**/vendor/**', '!**/_*.*'],
        dest: '<%= config.build %><%= package.name %>'
    },
    dev: {
        expand: true,
        cwd: '<%= config.root %>',
        src: ['**'],
        dest: '<%= config.build %><%= package.name %>'
    }
};