'use strict';
module.exports = function(grunt) {

    var pkg = grunt.file.readJSON('package.json');

    // Configuration
    var config = {
        root: 'theme', // or 'theme-child'
        css: '<%= config.root %>/assets/css',
        sass: '<%= config.root %>/assets/sass',
        js: '<%= config.root %>/assets/js',
        img: '<%= config.root %>/assets/img',
        build: 'build',
        tests: '<%= config.root %>/tests'
    };

    // Load all grunt tasks matching the `grunt-*` pattern
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        // Allow to use variables inside strings (for object keys)
        config: config,

        // Watch for changes
        watch: {
            sass: {
                files: ['<%= config.sass %>/**/*.{scss,sass}', '!<%= config.css %>/vendor/'],
                tasks: ['sass', 'autoprefixer', 'cssmin']
            },
            js: {
                files: '<%= jshint.all %>',
                tasks: ['jshint', 'uglify:main']
            }
        },

        // Sass
        sass: {
            dist: {
                options: {
                    style: 'expanded',
                },
                files: {
                    '<%= config.css %>/main.css': '<%= config.sass %>/main.scss',
                    '<%= config.css %>/editor-style.css': '<%= config.sass %>/editor-style.scss'
                }
            }
        },

        // Autoprefixer
        autoprefixer: {
            options: {
                browsers: ['last 2 versions', 'ie 9', 'ios 6', 'android 4'],
                map: true
            },
            files: {
                expand: true,
                flatten: true,
                src: config.css+'*.css',
                dest: config.css
            },
        },

        // CSS minify
        cssmin: {
            options: {
                keepSpecialComments: 1
            },
            minify: {
                expand: true,
                cwd: config.css,
                src: ['*.css', '!*.min.css'],
                ext: '.css'
            }
        },

        // Javascript linting with jshint
        jshint: {
            options: {
                jshintrc: '.jshintrc',
                "force": true
            },
            all: [
                'gruntfile.js',
                '<%= config.js %>/source/**/*.js'
            ]
        },

        // Uglify to concat, minify, and make source maps
        uglify: {
            plugins: {
                options: {
                    sourceMap: '<%= config.js %>/plugins.js.map',
                    sourceMappingURL: 'plugins.js.map',
                    sourceMapPrefix: 2
                },
                src : '<%= config.js %>/vendor/**/*.js',
                dest : '<%= config.js %>/plugins.min.js'
                // files: {
                //     '<%= config.js %>plugins.min.js': [
                //         config.js+'source/plugins.js', // Remove?
                //         config.js+'vendor/fastclick.js'
                //     ]
                // }
            },
            main: {
                options: {
                    sourceMap: '<%= config.js %>/main.js.map',
                    sourceMappingURL: 'main.js.map',
                    sourceMapPrefix: 2
                },
                src : '<%= config.js %>/source/**/*.js',
                dest : '<%= config.js %>/main.min.js'
                // files: {
                //     '<%= config.js %>/main.min.js': [
                //         '<%= config.js %>/source/main.js'
                //     ]
                // }
            }
        },

        // Copy files to the build folder
        copy: {
          dist: {
            expand: true,
            cwd: '<%= config.root %>/',
            src: ['**', '!**/sass/**', '!**/source/**', '!**/vendor/**', '!**/tests/**', '!**/_*.*'],
            dest: '<%= config.build %>/'+pkg.name,
          },
          dev: {
            expand: true,
            cwd: '<%= config.root %>/',
            src: ['**'],
            dest: '<%= config.build %>/'+pkg.name,
          },
        },

        // Image optimization
        imagemin: {
            dist: {
                options: {
                    optimizationLevel: 7,
                    progressive: true,
                    interlaced: true
                },
                files: [{
                    expand: true,
                    cwd: config.img,
                    src: ['**/*.{png,jpg,gif}'],
                    dest: '<%= config.img %>'
                }]
            }
        },

        // Compress the theme
        compress: {
          dist: {
            options: {
              archive: '<%= config.build %>/'+pkg.name+'.zip'
            },
            files: [
              {expand: true, cwd: '<%= config.build %>/'+pkg.name+'/', src: ['**'], dest: './'+pkg.name}
            ]
          }
        },

        clean: {
            dist: ['<%= config.build %>'],
        },

        // Launch browserSync
        browserSync: {
            dev: {
                bsFiles: {
                    src : ['main.css', '<%= config.js %>/*.js', '<%= config.img %>/**/*.{png,jpg,jpeg,gif,webp,svg}']
                },
                options: {
                    proxy: "localhost",
                    // host: "127.0.0.1",
                    watchTask: true
                }
            }
        },

        // Testing suite
        dalek: {
            options: {
                // browser: ['phantomjs', 'chrome'],
                browser: ['chrome'],
                reporter: ['console', 'html'],
                dalekfile: false,
                advanced: {
                    reporter: ['console', 'html'],
                    'html-reporter': {
                       dest: 'reports'
                    }
                }
            },

            dist: {
              src: ['<%= config.tests %>/**/*.js']
            }
        }

    });
    

    //////////////////////////////////////////////////////////////


    // Compile and watch
    grunt.registerTask('default', ['sass', 'autoprefixer', 'cssmin', 'uglify', 'watch']);

    // Compile only (useful when adding new js plugins)
    grunt.registerTask('compile', ['sass', 'autoprefixer', 'cssmin', 'uglify']);

    // Build and create a theme package ready for publishing
    grunt.registerTask('build', ['sass', 'autoprefixer', 'cssmin', 'uglify', 'clean', 'copy:dist', 'imagemin', 'compress']);

    // Build and create a theme package for development
    grunt.registerTask('build-dev', ['sass', 'autoprefixer', 'cssmin', 'uglify', 'clean', 'copy:dev', 'imagemin', 'compress']);

    // Run the tests
    grunt.registerTask('test', ['dalek']);


    //////////////////////////////////////////////////////////////

};
