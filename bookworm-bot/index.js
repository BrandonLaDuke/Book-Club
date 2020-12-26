const Discord = require('discord.js');
const config = require('config.json');
var XMLHttpRequest = require('./node_modules/xmlhttprequest/lib/XMLHttpRequest.js').XMLHttpRequest;
const client = new Discord.Client();


client.once('ready', () => {
	console.log('Ready!');
});

client.on('message', message => {
  prefix = `${config.prefix}`;
  const msgContAll = message.content;
  const msgCont = msgContAll.toLowerCase();

  if (!msgCont.startsWith(prefix) || message.author.bot) return;

  const args = message.content.slice(prefix.length).trim().split(' ');
  const command = args.shift().toLowerCase();

  console.log(command);
  
  if (message.content.startsWith(`${prefix}ping`)) {
    message.channel.send('Pong.');
  } else if (message.content.startsWith(`${prefix}beep`)) {
    message.channel.send('Boop.');
  } else if (message.content === `${prefix}server`) {
    message.channel.send(`This server's name is: ${message.guild.name}\nThere are ${message.guild.memberCount} book club members!`);
  }


  
  // If command is help
  if (command === 'help') {
    message.channel.send('Hello, I\'m Bookworm!\nI\'m here to help you out.\n\nType: *bookworm inspire* for an inspirational quote.\n\nMore commands are coming soon. I\'m still learning more.')
  } else if (command === 'inspire') {

    let requestURL = 'https://zenquotes.io/api/random';
  let request = new XMLHttpRequest();
  request.open('GET', requestURL);
  request.responseType = 'json';
  request.send();
  
  request.onreadystatechange = processRequest;
  async function processRequest(e) {
    if (request.readyState == 4 && request.status == 200) {
      let quoteMessage = JSON.parse(request.responseText);
      
  quote = quoteMessage[0].q + " -" + quoteMessage[0].a;
      console.log(quote);
      await message.channel.send(quote);
      return quote;
    }
  }
    
  }

  
});

client.login(config.token);