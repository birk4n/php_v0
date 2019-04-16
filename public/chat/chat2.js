//bağlantı
  const socket = io.connect('http://127.0.0.1:3000/chat2');

var message = document.getElementById('message'),
      handle = document.getElementById('handle'),
      btn = document.getElementById('send'),
      output = document.getElementById('output'),
      feedback=document.getElementById('feedback');

// Emit events
btn.addEventListener('click', function(){
  socket.emit('chat', {
      message: message.value,
      handle: handle.value
  });
  message.value = "";
});
message.addEventListener('keypress',function(){
  socket.emit('typing',handle.value);
});
// Listen for events
socket.on('chat', function(data){
  feedback.innerHTML="";
    output.innerHTML += '<p><strong>' + data.handle + ': </strong>' + data.message + '</p>';
});
socket.on('typing',function(data){
  feedback.innerHTML='<p><em>'+data +' yazıyor...</em></p>';
});
