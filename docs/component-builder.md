# Component Builder

The component builder offers an expressive way to generate
[Message Components](https://discord.com/developers/docs/interactions/message-components)
for a message. These components facilitate interactions, which can be handled by your
application.

Every set of components is wrapped in an [action row](https://discord.com/developers/docs/interactions/message-components#action-rows). Therefore
each instance of the `ComponentBuilder` will generate a single action row, comprised
of its components.

For more information on how to build components, see [Discord documentation](https://discord.com/developers/docs/interactions/message-components#what-is-a-component).

---

## Example

Let's setup an action row that contains a select menu and a button. We will
add specific `custom_id`'s to each component so that we can identify them later during
an interaction event.

```phpt
use Nwilging\LaravelDiscordBot\Support\Builder\ComponentBuilder;

$myButtonId = 'button-1';
$myMenuId = 'menu-1';

$componentBuilder = new ComponentBuilder();
```

Next let's setup the option values for the select menu:
```phpt
$option1 = 'option-value-1';
$option2 = 'option-value-2';
```

Since we want the select menu to appear above our button in the action, we need
to add it first. We can also use the `ComponentBuilder` to quickly add options to
the menu:
```phpt
$componentBuilder->addSelectMenuComponent([
    $componentBuilder->withSelectOptionObject('Option 1 Label', $option1),
    $componentBuilder->withSelectOptionObject('Option 2 Label', $option2),
], $myMenuId);
```

Now we can add our button:
```phpt
$componentBuilder->addActionButton('Submit', $myButtonId);
```

Full example:
```phpt
use Nwilging\LaravelDiscordBot\Support\Builder\ComponentBuilder;
use Nwilging\LaravelDiscordBot\Contracts\Services\DiscordApiServiceContract;

$myButtonId = 'button-1';
$myMenuId = 'menu-1';

$componentBuilder = new ComponentBuilder();

$option1 = 'option-value-1';
$option2 = 'option-value-2';

$componentBuilder->addSelectMenuComponent([
    $componentBuilder->withSelectOptionObject('Option 1 Label', $option1),
    $componentBuilder->withSelectOptionObject('Option 2 Label', $option2),
], $myMenuId);

$componentBuilder->addActionButton('Submit', $myButtonId);

$actionRow = $componentBuilder->getActionRow();

# Send this component as a message
$apiService = app(DiscordApiServiceContract::class);
$apiService->sendRichTextMessage(
    'channel ID',
    [], // no embeds this time
    [
        $componetBuilder->getActionRow(),
        // You can add additional action rows if desired
    ],
);
```
