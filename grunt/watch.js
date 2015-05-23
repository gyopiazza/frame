// Watch for changes
module.exports = {
	sass: {
        files: ['<%= config.root %><%= config.css %>source/**/*.{scss,sass}', '!<%= config.root %><%= config.css %>vendor/'],
        tasks: ['newer:sass:dev', 'newer:autoprefixer', 'newer:combine_mq', 'newer:cssmin', 'notify:watch']
    },
    js: {
        files: '<%= jshint.all %>',
        tasks: ['newer:jshint', 'newer:uglify:main', 'notify:main_js']
    },
    js_plugins: {
        files: '<%= config.root %><%= config.js %>vendor/**/*.js',
        tasks: ['newer:uglify:plugins', 'notify:plugins_js']
    }
};
