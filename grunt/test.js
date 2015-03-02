module.exports = function (grunt) {

    // or use grunt.registerMultiTask
    grunt.registerTask('test', 'Run the tests', function(arg1) {
        var target = grunt.option('target');

        if (arguments.length === 0) {
            grunt.log.writeln(this.name + ", no args");
            grunt.task.run(['dalek']);
        } else {
            grunt.log.writeln(this.name + ", " + arg1);
            grunt.config.set('test.file', arg1);
            grunt.task.run('dalek:one');
        }

        // grunt.log.writeln('The task was OK!');
    });

};
