# Elementor Hello World Sample Plugin

This is a sample plugin to demonstrate how you can write extentions (plugins) to add custom functionality to [Elementor](https://github.com/pojome/elementor/)

Plugin Structure: 
```
assets/
      /js   
      /css  Holds plugin CSS Files
      
widgets/
      /hello-world.php
      /inline-editing.php
      
index.php
elementor-hello-world.php
plugin.php
```


* `assets` directory - holds plugin JavaScript and CSS assets
  * `/js` directory - Holds plugin Javascript Files
  * `/css` directory - Holds plugin CSS Files
* `widgets` directory - Holds Plugin widgets
  * `/hello-world.php` - Hello World demo Widget class
  * `/inline-editing.php` - Inline Editing demo Widget class
* `index.php`	- Prevent direct access to directories
* `elementor-hello-world.php`	- Main plugin file, used as a loader if plugin minimum requirements are met.
* `plugin.php` - The actual Plugin file/Class.

For more documentation please see [Elementor Developers Resource](https://developers.elementor.com/creating-an-extension-for-elementor/).
