// Launch browserSync
module.exports = {
    dev: {
        bsFiles: {
            src : ['<%= config.root %>**/*.html', '<%= config.root %>**/*.php', '<%= config.root %><%= config.css %>*.css', '<%= config.root %><%= config.js %>*.js', '<%= config.root %><%= config.img %>**/*.{png,jpg,jpeg,gif,webp,svg}']
        },
        options: {
            // proxy: "localhost",
            // proxy: "http://localwebsite.dev/",
            watchTask: true,
            server: {
                baseDir: "./project/"
            }
        }
    }
};
