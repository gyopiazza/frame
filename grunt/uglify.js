// Uglify to concat, minify, and make source maps
module.exports = {
    main: {
        options: {
            sourceMap: '<%= config.root %><%= config.js %>main.js.map',
            sourceMappingURL: 'main.js.map',
            sourceMapPrefix: 2
        },
        src: '<%= config.root %><%= config.js %>source/**/*.js',
        dest: '<%= config.root %><%= config.js %>main.js'
        // files: {
        //     '<%= config.js %>/main.min.js': [
        //         '<%= config.js %>/source/main.js'
        //     ]
        // }
    },
    main_build: {
        options: {
            sourceMap: false
        },
        src: '<%= config.root %><%= config.js %>source/**/*.js',
        dest: '<%= config.root %><%= config.js %>main.js'
    },
    plugins: {
        options: {
            sourceMap: '<%= config.root %><%= config.js %>plugins.js.map',
            sourceMappingURL: 'plugins.js.map',
            sourceMapPrefix: 2
        },
        src: '<%= config.root %><%= config.js %>vendor/**/*.js',
        dest: '<%= config.root %><%= config.js %>plugins.js'
        // files: {
        //     '<%= config.js %>plugins.min.js': [
        //         config.js+'vendor/fastclick.js'
        //     ]
        // }
    },
    plugins_build: {
        options: {
            sourceMap: false
        },
        src: '<%= config.root %><%= config.js %>vendor/**/*.js',
        dest: '<%= config.root %><%= config.js %>plugins.js'
    },
};
