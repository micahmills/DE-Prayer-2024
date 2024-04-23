<?php

class PluginTest extends TestCase
{
    public function test_plugin_installed() {
        activate_plugin( 'de-prayer-2024/de-prayer-2024.php' );

        $this->assertContains(
            'de-prayer-2024/de-prayer-2024.php',
            get_option( 'active_plugins' )
        );
    }
}
