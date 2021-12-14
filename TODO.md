# TODO

For now I'm currently:
- correct SQL instruction (auto increment, default to current timestamp, etc...)
- check current log for errors I don't see (~ 1000 lines to check)
- update error page presentation with translation

Then,
- Each retrieve method (retrieve<Something>()) return what it retrieves even if it's stored
- Use token based auth (see split token here (https://paragonie.com/blog/2017/02/split-tokens-token-based-authentication-protocols-without-side-channels) and here (https://stackoverflow.com/questions/3128985/php-login-system-remember-me-persistent-cookie/, note already in class/user/Visitor.class.php in connect method))
- Each typed method argument must be preceded by its type
- Each function used (native or not) is preceded by \ because it's in root namespace
- Installation script on first run (protected by password?)
- Add hooks to upgrade modding power
- Make core\Logger::log() method take an array if a message has to be logged in two channels (types)
