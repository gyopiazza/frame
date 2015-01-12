// CSS minify
module.exports = {
	options: {
        keepSpecialComments: 1
    },
    minify: {
        expand: true,
        cwd: '<%= config.root %><%= config.css %>',
        src: ['*.css', '!*.min.css'],
        ext: '.css',
        dest: '<%= config.root %><%= config.css %>'
    }
};