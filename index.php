<?php
// PHP: Save log to server file
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['log'])) {
    $log = htmlspecialchars($_POST['log']);
    file_put_contents("hack_logs.txt", date("Y-m-d H:i:s") . " — " . $log . "\n", FILE_APPEND);
    echo "✅ Log saved successfully.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hacker Tycoon: Red Hat Edition</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Courier New', monospace;
      background: radial-gradient(circle, #0a0a0a 40%, #010101 100%);
      color: #39ff14;
      overflow: hidden;
    }

    #terminal {
      background: rgba(0, 0, 0, 0.85);
      border: 2px solid #39ff14;
      height: 60vh;
      padding: 20px;
      overflow-y: auto;
      box-shadow: 0 0 20px #39ff14;
      animation: scanline 1s infinite linear;
    }

    @keyframes scanline {
      0% { box-shadow: 0 0 20px #39ff14; }
      50% { box-shadow: 0 0 40px #39ff14; }
      100% { box-shadow: 0 0 20px #39ff14; }
    }

    .neon-glow {
      text-shadow: 0 0 5px #39ff14, 0 0 10px #39ff14, 0 0 20px #39ff14;
    }

    input:focus {
      outline: none;
    }

    ::-webkit-scrollbar {
      width: 6px;
    }

    ::-webkit-scrollbar-thumb {
      background: #39ff14;
    }

    .scanline-bg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,255,0,0.03) 3px);
      pointer-events: none;
    }

    .bg-glow {
      box-shadow: 0 0 10px #39ff14, inset 0 0 10px #39ff14;
    }
  </style>
</head>
<body class="relative p-6 text-green-400 min-h-screen">
  <div class="scanline-bg"></div>

  <div class="max-w-4xl mx-auto relative z-10">
    <h1 class="text-4xl font-bold neon-glow mb-4 text-center">💻 Hacker Tycoon: Red Hat Edition</h1>

    <div id="terminal" class="rounded-lg bg-glow text-sm mb-4">
      <p>Initializing system terminal...<br>Type <span class="text-pink-400">help</span> to get started.</p>
    </div>

    <form id="commandForm" class="flex items-center space-x-2">
      <span class="text-pink-400 font-bold">root@redhat:</span>
      <input id="commandInput" type="text" placeholder="Enter command..." class="bg-transparent w-full text-green-300 placeholder-green-500 border-b border-green-500 py-2 px-3" autocomplete="off" />
    </form>

    <audio autoplay loop>
      <source src="https://files.freemusicarchive.org/storage-freemusicarchive-org/music/no_curator/Sawsquarenoise/Nautilus/Sawsquarenoise_-_10_-_Phase_Shift.mp3" type="audio/mp3">
    </audio>
  </div>

  <script>
    const terminal = document.getElementById("terminal");
    const form = document.getElementById("commandForm");
    const input = document.getElementById("commandInput");

    const commands = {
      help: `
🔐 Available Commands:
• hack      - Start a basic system breach
• logs      - View system log info
• clear     - Clear the terminal
• credits   - Dev info`,
      hack: "🔥 Initiating breach...\n🔓 Accessing target IP...\n🟢 Success! You gained 100 rep points.",
      credits: "🧠 Hacker Tycoon by RhyzilDev\n📀 Built using Tailwind, PHP, and synthwave vibes ⚡",
      logs: "📄 Hack logs saved in server file [hack_logs.txt]. Type 'hack' to generate one."
    };

    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      const cmd = input.value.trim().toLowerCase();
      if (!cmd) return;

      appendToTerminal(`> ${cmd}`);

      if (cmd === "clear") {
        terminal.innerHTML = "";
      } else if (commands[cmd]) {
        typeOut(commands[cmd]);
        if (cmd === "hack") saveLog("User ran 'hack' command.");
      } else {
        typeOut("❌ Unknown command. Type 'help'.");
      }

      input.value = "";
    });

    function appendToTerminal(text) {
      terminal.innerHTML += `<div>${text}</div>`;
      terminal.scrollTop = terminal.scrollHeight;
    }

    function typeOut(text) {
      let i = 0;
      const speed = 20;
      const line = document.createElement("div");
      terminal.appendChild(line);

      const typing = setInterval(() => {
        if (i < text.length) {
          line.innerHTML += text[i] === "\n" ? "<br>" : text[i];
          terminal.scrollTop = terminal.scrollHeight;
          i++;
        } else {
          clearInterval(typing);
        }
      }, speed);
    }

    function saveLog(logText) {
      fetch("", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "log=" + encodeURIComponent(logText)
      });
    }
  </script>
</body>
</html>
