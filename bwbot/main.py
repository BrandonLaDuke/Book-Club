import discord
import os
import requests
import json

client = discord.Client()

def get_quote():
  response = requests.get("https://zenquotes.io/api/random")
  json_data = json.loads(response.text)
  quote = json_data[0]['q'] + " -" + json_data[0]['a']
  return(quote)

@client.event
async def on_ready():
    print('We have logged in as {0.user}'.format(client))

@client.event
async def on_message(message):
    if message.author == client.user:
        return

    if message.content.startswith('bookworm'):
      com_word = message.content.split("bookworm ",1)[1]
      if com_word == 'inspire':
        quote = get_quote()
        await message.channel.send(quote)
      elif com_word == 'help':
        await message.channel.send('Hello, I\'m Bookworm!\nI\'m here to help you out.\n\nType: *bookworm inspire* for an inspirational quote.\n\nI\'m still learning more.')
      elif com_word == "test":
        await message.channel.send('Hello there! from Spinelessbound')
    
    if message.content.startswith('$inspire'):
      quote = get_quote()
      await message.channel.send(quote)

client.run(os.getenv('TOKEN'))