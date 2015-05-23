// Combine media queries
module.exports = {
	// options: {
 //      expand: true,
 //      cwd: '<%= config.root %><%= config.css %>',
 //      src: '*.css',
 //      dest: '<%= config.root %><%= config.css %>'
 //    },
 //    build: {
 //        options: {
 //            expand: true,
 //            beautify: false
 //        },
 //        cwd: '<%= config.build %><%= config.css %>',
 //        src: '*.css',
 //        dest: '<%= config.build %><%= config.css %>'
 //    }
    dist: {
        expand: true,
        cwd: '<%= config.root %><%= config.css %>',
        src: '*.css',
        dest: '<%= config.root %><%= config.css %>'
    }
};
