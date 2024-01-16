<?php

class PluginTest extends TestCase
{
    public function test_plugin_installed() {
        activate_plugin( 'ramadan-2024/ramadan-2024.php' );

        $this->assertContains(
            'ramadan-2024/ramadan-2024.php',
            get_option( 'active_plugins' )
        );
    }
}
