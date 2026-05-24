<?php
/**
 * Plugin Name: Seller Fast AI Chatbot
 * Description: Official AI Chatbot auto-installer for Seller Fast. Instantly adds your intelligent AI assistant to your WooCommerce store.
 * Version: 1.0.2
 * Author: NextByte Digital
 * Author URI: https://sellerfast.tech
 * License: GPL v2 or later
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

// Enqueue CSS and JS the standard WordPress way
add_action( 'wp_enqueue_scripts', 'sellerfast_chatbot_enqueue_assets' );
function sellerfast_chatbot_enqueue_assets() {
    wp_enqueue_style( 'sellerfast-chatbot-style', plugin_dir_url( __FILE__ ) . 'assets/chatbot.css', array(), '1.0.2' );
    wp_enqueue_script( 'sellerfast-chatbot-script', plugin_dir_url( __FILE__ ) . 'assets/chatbot.js', array(), '1.0.2', true );

    // Pass dynamic URL to JavaScript securely with proper prefix
    wp_localize_script( 'sellerfast-chatbot-script', 'sellerfast_chatbot_config', array(
        'storeUrl'   => home_url(),
        'webhookUrl' => 'YOUR_WEBHOOK_URL_HERE'
    ) );
}

// Inject Premium HTML UI
add_action( 'wp_footer', 'sellerfast_chatbot_inject_html' );
function sellerfast_chatbot_inject_html() {
    ?>
    <div id="saas-chatbot-container">
      <div id="saas-chatbot-window">
        <div id="saas-chatbot-header">
          <div class="header-content">
            <div class="header-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>
            </div>
            <div class="header-text">
              <h2>Seller Fast</h2>
              <p>Always here to help</p>
            </div>
          </div>
          <span id="saas-chatbot-close" onclick="toggleChat()">×</span>
        </div>
        <div id="saas-chatbot-messages">
          <div class="chat-wrapper bot">
            <div class="avatar">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg>
            </div>
            <div class="chat-msg bot">Hi there! 👋 Welcome to our store. Feel free to ask me anything!</div>
          </div>
        </div>
        <div id="saas-chatbot-input-area">
          <input type="text" id="saas-chatbot-input" placeholder="Type your message here..." />
          <button id="saas-chatbot-send">
            <svg viewBox="0 0 24 24"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
          </button>
        </div>
      </div>
      <div id="saas-chatbot-btn" onclick="toggleChat()">
        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 5.92 2 10.75c0 2.66 1.45 5.04 3.73 6.64l-1.42 3.86c-.19.53.38.99.85.74l4.28-2.22c.83.17 1.69.27 2.56.27 5.52 0 10-3.92 10-8.75S17.52 2 12 2zm0 15.5c-.75 0-1.5-.08-2.23-.23l-.32-.07-2.67 1.38.89-2.42-.23-.21C5.66 14.7 4.5 12.83 4.5 10.75 4.5 7.16 7.86 4.25 12 4.25s7.5 2.91 7.5 6.5-3.36 6.5-7.5 6.5z"/></svg>
      </div>
    </div>
    <?php
}