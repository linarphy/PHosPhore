# TODO

For now I'm currently:
- correct SQL instruction (auto increment, default to current timestamp, etc...)
- correct the bug (count cannot be used on string)
- check if all hydrating method are the same as \core\Managed one (I replaced $this->$attribute != null by property_exists($attribute))
- check current log for errors I don't see
- make the error page to display (proprely)

Then,
- Create missing locale, lang & config files
- Each retrieve method (retrieve<Something>()) return what it retrieves even if it's stored
- Use token based auth (see split token here (https://paragonie.com/blog/2017/02/split-tokens-token-based-authentication-protocols-without-side-channels) and here (https://stackoverflow.com/questions/3128985/php-login-system-remember-me-persistent-cookie/, note already in class/user/Visitor.class.php in connect method))
- Each typed method argument must be preceded by its type
- Installation script on first run (protected by password?)
- Add hooks to upgrade modding power
