function toggleChat() {
  const win = document.getElementById("saas-chatbot-window");
  win.style.display = win.style.display === "flex" ? "none" : "flex";
}

document.getElementById("saas-chatbot-send").addEventListener("click", sendMessage);
document.getElementById("saas-chatbot-input").addEventListener("keypress", function(e) {
  if (e.key === "Enter") sendMessage();
});

async function sendMessage() {
  const input = document.getElementById("saas-chatbot-input");
  const msg = input.value.trim();
  if (!msg) return;

  addMessage(msg, "user");
  input.value = "";
  const typingId = "typing-" + Date.now();
  addMessage("...", "bot", typingId);

  try {
    // WordPress API Logic Kept Intact
    const urlToFetch = sellerfast_chatbot_config.webhookUrl + "?question=" + encodeURIComponent(msg) + "&storeUrl=" + encodeURIComponent(sellerfast_chatbot_config.storeUrl);
    const response = await fetch(urlToFetch);
    const data = await response.text();
    document.getElementById(typingId).remove();
    addMessage(data, "bot");
  } catch (err) {
    document.getElementById(typingId).remove();
    addMessage("Sorry, connection error.", "bot");
  }
}

// Updated DOM Logic for Premium Design
function addMessage(text, sender, id = null) {
  const wrapperDiv = document.createElement("div");
  wrapperDiv.className = "chat-wrapper " + sender;
  if (id) wrapperDiv.id = id;

  let innerHTML = '';
  
  if (sender === 'bot') {
    innerHTML += '<div class="avatar"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2"/><path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/></svg></div>';
  }

  let formattedText = text;
  
  if (text === "...") {
    formattedText = '<div class="sellerfast-typing"><div class="sellerfast-dot"></div><div class="sellerfast-dot"></div><div class="sellerfast-dot"></div></div>';
  } else {
    // Formatting logic kept intact
    formattedText = text.replace(/\[([^\]]+)\]\((https?:\/\/[^\s)]+)\)/g, function(match, title, url) {
      return '<a href="' + url + '" target="_blank" style="color: #3178ff; text-decoration: underline; font-weight: bold;">' + title + '</a>';
    });
    formattedText = formattedText.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
    formattedText = formattedText.replace(/\n/g, '<br>');
  }

  innerHTML += '<div class="chat-msg ' + sender + '">' + formattedText + '</div>';
  wrapperDiv.innerHTML = innerHTML;

  document.getElementById("saas-chatbot-messages").appendChild(wrapperDiv);
  document.getElementById("saas-chatbot-messages").scrollTop = document.getElementById("saas-chatbot-messages").scrollHeight;
}