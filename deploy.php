<?php

namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'apex');

// Project repository
set('repository', 'git@github.com:wagura-maurice/apex.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);
set('default_timeout', 150000);

// Shared files/dirs between deploys
add('shared_files', [
    '.env',
    'wp-config.php',
]);

add('shared_dirs', [
    'wp-content/uploads',
]);

// Writable dirs by web server
add('writable_dirs', [
    'wp-content/uploads',
]);

// Hosts
host('206.189.120.35')
    ->user('deployer')
    ->port(22)
    ->identityFile('~/.ssh/id_rsa')
    ->set('deploy_path', '/var/www/html/{{application}}');

// WordPress-specific release tasks
task('release:application', function () {
    // Set proper permissions for WordPress
    run('chmod -R 755 {{release_path}}');
    run('chmod -R 775 {{release_path}}/wp-content/uploads');
    
    // Clear any WordPress cache if using a caching plugin
    // Uncomment and modify based on your caching solution
    // run('rm -rf {{release_path}}/wp-content/cache/*');
    
    // Flush rewrite rules by touching .htaccess (optional)
    // run('touch {{release_path}}/.htaccess');
})->once();

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');


// Run WordPress tasks before symlink new release
before('deploy:symlink', 'release:application');

// Main deploy task
task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:symlink',
    'deploy:unlock',
    'deploy:clear_paths',
]);

desc('Deploy WordPress');
