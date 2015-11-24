<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar main-nav',
 
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'question'  => [
            'text'  => 'Frågor',
            'url'   => $this->di->get('url')->create('questions/list'),
            'title' => 'Alla frågor',
            'mark-if-parent-of' => 'question',
        ],
 
        // This is a menu item
        'tag' => [
            'text'  =>'Taggar',
            'url'   => $this->di->get('url')->create('tags/list'),
            'title' => 'Alla taggar',
            'mark-if-parent-of' => 'tag'
        ],

        // This is a menu item
        'user' => [
            'text'  =>'Användare',
            'url'   => $this->di->get('url')->create('user/list'),
            'title' => 'Alla användare',
            'mark-if-parent-of' => 'user'
        ],

        // This is a menu item
        'about' => [
            'text'  =>'Om oss',
            'url'   => $this->di->get('url')->create('about'),
            'title' => 'Om oss på allt-om-burgare'
        ],
    ],
 


    /**
     * Callback tracing the current selected menu item base on scriptname
     *
     */
    'callback' => function ($url) {
        if ($url == $this->di->get('request')->getCurrentUrl(false)) {
            return true;
        }
    },



    /**
     * Callback to check if current page is a decendant of the menuitem, this check applies for those
     * menuitems that has the setting 'mark-if-parent' set to true.
     *
     */
    'is_parent' => function ($parent) {
        $route = $this->di->get('request')->getRoute();
        return !substr_compare($parent, $route, 0, strlen($parent));
    },



   /**
     * Callback to create the url, if needed, else comment out.
     *
     */
   /*
    'create_url' => function ($url) {
        return $this->di->get('url')->create($url);
    },
    */
];
