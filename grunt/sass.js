// Compile Sass files
module.exports = {
	dist: {
        options: {
            style: 'expanded',
        },
        files: {
            '<%= config.root %><%= config.css %>main.css': '<%= config.root %><%= config.sass %>main.scss',
            '<%= config.root %><%= config.css %>editor-style.css': '<%= config.root %><%= config.sass %>editor-style.scss'
        }
    }
};