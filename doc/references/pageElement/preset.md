# Preset

## What is a preset

Preset are a set of two `\content\pageelement\PageElement`:

- `page_element`: describe the stucture of the page
- `notification_element`: describe the structure of a notification on this page

## Making a preset

`page_element` template must contains a key `notifications`, which will be automaticaly be filled with notifications element.
`notification_element` template can only contains three keys:

- `type`: type of the notification
- `date`: date of the notification
- `content`: content of the notification

These key will be automaticaly filled with value from the notification.

## Available presets

There are currently two available presets:

- `default_html`: content goes in `body` key, html head content can be put in the `head` key
- `none`: no template, every values will be structured as in the object definition, next to each other
