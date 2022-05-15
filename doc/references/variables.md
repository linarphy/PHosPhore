# Other reserved variables 

- [`$_GET`](#$_GET)
- [`$_SESSION`](#$_SESSION)

## `$_GET`

- `__path__`: url used if the Router use the GET mode
- `__locale__`: user lang (2nd priority)

## `$_SESSION`

- `__locale__`: user lang (1st priority)
- `__notifications__`: notification sent for the next page
- [`__login__`](#__login__)

### `__login__`

User credential

- `selector`: auth token selector (clear)
- `validator`: auth token validator (hashed)
