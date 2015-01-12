// Autoprefixer
module.exports = {
    options: {
        browsers: ['last 2 versions', 'ie 9', 'ios 6', 'android 4'],
        map: true
    },
    files: {
        expand: true,
        flatten: true,
        src: '<%= config.root %><%= config.css %>*.css',
        dest: '<%= config.root %><%= config.css %>'
    },
};