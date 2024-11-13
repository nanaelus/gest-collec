<div class="row">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-header">
                Choisir son interlocuteur
            </div>
            <div class="card-body">
                <select id="receiver" class="form-select">
                    <?php foreach ($users as $u) : ?>
                        <?php if ($u['id'] != $user->id) : ?>
                            <option value="<?= $u['id']; ?>">
                                <?= $u['username']; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-header">
                Messages
            </div>
            <div class="card-body overflow-auto position-relative" id="m-area" style="height: 50vh">

            </div>
            <div class="card-footer p-3">
                <textarea rows="4" id="message" class="form-control"></textarea>
                <button class="btn btn-primary mt-2" id="send">Envoyer</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        let id_receiver =  $('#receiver').val();
        let id_sender =  <?= $user->id; ?>;
        let baseUrl = "<?= base_url(); ?>";
        let lastMessageTimestamp;
        getMessageHistory();
        setInterval(getNewMessage,5000);

        /* Au changement d'interlocuteur */
        $('#receiver').change(function(){
            id_receiver = $(this).val();
            getMessageHistory();
        });

        /* Validation de l'envoie d'un message */
        $('#send').click(function(){
            let content = $('#message').val();
            if(content) {
                if (id_receiver) {
                    $.ajax({
                        url: baseUrl + 'chat/ajaxsendmessage',
                        type: 'POST',
                        data: {
                            'id_receiver': id_receiver,
                            'id_sender': id_sender,
                            'content': content,
                        },
                        success: function (data) {
                            //console.log(data);
                            $('#m-area').append(senderMessage(data));
                            scrollToBottom();
                            $('#message').val('');
                        }
                    })
                }
            }
        });


        /*
        ** Récupère l'historique de la conversation
         */
        function getMessageHistory(){
            $.ajax({
                url: baseUrl + 'chat/ajaxmessagehistory',
                type : 'GET',
                data : {
                    'id_receiver': id_receiver,
                    'id_sender': id_sender,
                },
                success : function(data) {
                    //console.log(data);
                    $('#m-area').html('');
                    if (data.length > 0) {
                        data.forEach(function(message) {
                            if (message.id_sender == id_sender) {
                                $('#m-area').prepend(senderMessage(message));
                            } else {
                                $('#m-area').prepend(receiverMessage(message));
                            }
                        });
                        lastMessageTimestamp = data[0].created_at;
                        scrollToBottom();
                    } else {
                        $('#m-area').append('<div class="row"><div class="col">Pas de message avec cette personne</div></div>');
                    }
                }
            });
        }

        /* Récupère les derniers messages */
        function getNewMessage(){
            $.ajax({
                url: baseUrl + 'chat/ajaxlastmessagehistory',
                type : 'GET',
                data : {
                    'id_receiver': id_receiver,
                    'id_sender': id_sender,
                    'limit' : 5,
                    'offset' : 0,
                    'timestamp' : lastMessageTimestamp
                },
                success : function(data) {
                    if (data.length > 0) {
                        data.forEach(function(message) {
                            if (message.id_sender != id_sender) {
                                $('#m-area').append(receiverMessage(message));
                            }
                            $('#m-area').append(`<div class="position-absolute bottom-0 start-50 translate-middle alert alert-light mb-0 p-2 z-3" style="font-size: 0.6em;">
                                <i class="fa-regular fa-circle-down"></i> Nouveau(x) Message(s) <i class="fa-regular fa-circle-down"></i>
                            </div>`);
                        });
                        lastMessageTimestamp = data[0].created_at;
                    }
                    console.log(data);
                }
            });
        }
        /* Message pour le receiver */
        function receiverMessage(message){
            let html = `
                <div class="row text-start">
                    <div class="col-md-8">
                        <div class="alert alert-secondary">
                            ${message.content}
                        </div>
                    </div>
                </div>
            `;
            return html;
        }
        /* Message pour le sender */
        function senderMessage(message){
            let html = `
                <div class="row text-end">
                    <div class="col-md-8 offset-md-4">
                        <div class="alert alert-primary">
                            ${message.content}
                        </div>
                    </div>
                </div>
            `;
            return html;
        }

        /* Fonction pour scroller vers le bas dans la zone des messages */
        function scrollToBottom() {
            let mArea = $('#m-area');
            mArea.scrollTop(mArea.prop("scrollHeight"));  // Scrolle jusqu'en bas
        }
    });
</script>