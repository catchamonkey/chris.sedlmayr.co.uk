set :application,       "chris.sedlmayr"
# set :domain,          "#{application}.co.uk"
set :domain,            "149.5.47.52"
set :deploy_to,         "/home/sites/chris.sedlmayr.co.uk"
set :app_path,          "app"
set :user,              "chris.sedlmayr"
set :server,            "149.5.47.52"

set :repository,        "git@github.com:catchamonkey/chris.sedlmayr.co.uk.git"
set :scm,               :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager,     "doctrine"
# Or: `propel`

role :web,              domain                         # Your HTTP server, Apache/etc
role :app,              domain                         # This may be the same as your `Web` server
role :db,               domain, :primary => true       # This is where Symfony2 migrations will run

set  :keep_releases,    3
set  :shared_children,  [log_path, cache_path, web_path + "/uploads"]
set  :shared_files,     ["app/config/parameters.yml"]
set  :use_composer,     true
set  :composer_options, "--verbose --prefer-dist --no-scripts"
set  :use_sudo,         false

default_run_options[:pty] = true
ssh_options[:forward_agent] = true

set  :webserver_user,    "apache"
set  :writable_dirs,     [log_path, cache_path]
# Method used to set permissions (:chmod, :acl, or :chown)
set  :permission_method, :acl

# Execute set permissions
set  :use_set_permissions, true

set  :cache_warmup,        true

set  :dump_assetic_assets, true
set  :update_assets_version,    true

after "deploy",                 "deploy:cleanup"
# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL