// Watch for changes
module.exports = {
	sass: {
        files: ['<%= config.root %><%= config.sass %>**/*.{scss,sass}', '!<%= config.root %><%= config.css %>vendor/'],
        tasks: ['sass', 'autoprefixer', 'cssmin']
    },
    js: {
        files: '<%= jshint.all %>',
        tasks: ['jshint', 'uglify:main']
    }
};