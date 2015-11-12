# 1:NextGen2 Sass Project

Front-end file package to manage stylesheets for the NextGen platform. Comes with its' own gridsystem and functions ready to use.

## Installation

Install all packages with npm .In folder amanda/ write
`$ npm install`


## Usage

Start application by writing:
`$ gulp`

### Basic usage

Write all of your scss code in the scss-files. Check _mixins.scss, _variables.scss and _grid.scss to see what functions and variables are available.


### How to add new css file to project

Add the file to your design.ini.append.php with the css extension like so
`new-file.css`

Then create it in your sass-folder but with the .scss ending like so
`new-file.scss`

Be sure to include engine on top of the file to get access to all variables. Like so

`/* Imports all variables and mixins */
 @import 'engine';`

## History

...
