'use strict';
module.exports = function(grunt) {

  grunt.initConfig({
    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      all: [
        'Gruntfile.js',
        'assets/js/*.js',
        '!assets/js/scripts.min.js'
      ]
    },
    less: {
      
        prod2: {
            files: {
              'assets/css/style.css': [
                'assets/less/style.less'
              ]
            },
            options: {
              compress: false,
              sourceMap: false
            }
        }
    },
   
    watch: {
      less: {
        files: [
          'assets/less/**/*.less'
        ],
        tasks: ['less']
      },
     },
    clean: {
      dist: [
        'assets/css/style.css'
      ]
    }
  });

  // Load tasks
  grunt.loadNpmTasks('grunt-contrib-clean');  // Clean files and folders.
  grunt.loadNpmTasks('grunt-contrib-watch');  // Run predefined tasks whenever watched file patterns are added, changed or deleted.  
  grunt.loadNpmTasks('grunt-contrib-less');   // Compile LESS files to CSS. 
  

  // Register tasks
  grunt.registerTask('default', [
    'clean',
    'less',
  ]);
  grunt.registerTask('dev', [

//    'prod2',
    'watch'
  ]);
};
