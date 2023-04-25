# Helpers and Supporting Classes

1. [Components](#components)
2. [Embeds](#embeds)
3. [Commands](#commands)

## Components

Helper classes for building [message components](https://discord.com/developers/docs/interactions/message-components).

**Parent Namespace:** `Nwilging\LaravelDiscordBot\Support\Components`

1. [`ActionRow`](https://discord.com/developers/docs/interactions/message-components#action-rows)
2. [`ButtonComponent`](https://discord.com/developers/docs/interactions/message-components#buttons)
3. [`SelectMenuComponent`](https://discord.com/developers/docs/interactions/message-components#select-menus)
4. [`LinkButtonComponent`](https://discord.com/developers/docs/interactions/message-components#buttons-link-button)
5. [`ParagraphTextInputComponent`](https://discord.com/developers/docs/interactions/message-components#text-inputs-text-input-structure)
6. [`ShortTextInputComponent`](https://discord.com/developers/docs/interactions/message-components#text-inputs-text-input-structure)

## Embeds

Helper classes for building [embeds](https://discord.com/developers/docs/resources/channel#embed-object).

**Parent Namespace:** `Nwilging\LaravelDiscordBot\Support\Embeds`

1. [`AuthorEmbed`](https://discord.com/developers/docs/resources/channel#embed-object-embed-author-structure)
2. [`FieldEmbed`](https://discord.com/developers/docs/resources/channel#embed-object-embed-field-structure)
3. [`FooterEmbed`](https://discord.com/developers/docs/resources/channel#embed-object-embed-footer-structure)
4. [`ImageEmbed`](https://discord.com/developers/docs/resources/channel#embed-object-embed-image-structure)
5. [`ProviderEmbed`](https://discord.com/developers/docs/resources/channel#embed-object-embed-provider-structure)
6. [`ThumbnailEmbed`](https://discord.com/developers/docs/resources/channel#embed-object-embed-thumbnail-structure)
7. [`VideoEmbed`](https://discord.com/developers/docs/resources/channel#embed-object-embed-video-structure)

### The `GenericEmbed` class

A "generic embed" represents a generic rich text embed component. These embeds support
add multiple other embeds such as author, fields, etc.

If you would like to combine multiple embed objects into a single message, you should
do so using the `GenericEmbed` class.

## Commands

Helper classes for building [application commands](https://discord.com/developers/docs/interactions/application-commands).

**Parent Namespace:** `Nwilging\LaravelDiscordBot\Support\Commands`

1. [`MessageCommand`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-types)
2. [`SlashCommand`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-types)
3. [`UserCommand`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-types)

### Command Options

**Parent Namespace:** `Nwilging\LaravelDiscordBot\Support\Commands\Options`

1. [`AttachmentOption`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-type)
2. [`BooleanOption`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-type)
3. [`ChannelOption`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-type)
4. [`IntegerOption`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-type)
5. [`MentionableOption`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-type)
6. [`NumberOption`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-type)
7. [`RoleOption`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-type)
8. [`StringOption`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-type)
9. [`SubCommandOption`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-type)
10. [`SubCommandGroupOption`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-type)
11. [`UserOption`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-type)
12. [`OptionChoice`](https://discord.com/developers/docs/interactions/application-commands#application-command-object-application-command-option-choice-structure)
