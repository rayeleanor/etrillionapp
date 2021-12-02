<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-comments"></i> <?=translate('chat')?></h4>
            </header>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 users">
                        <div class="new-chat">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">New
                                chat</button>
                        </div>
                        <div class="user-list panel">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <section class="msger">

                            <main class="msger-chat">
                            </main>

                            <form class="msger-inputarea">
                                <input type="text" class="msger-input" placeholder="Enter your message..." disabled='true' readonly='true' required>
                                <button type="submit" class="msger-send-btn btn-primary btn">Send</button>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Search User</h4>
            </div>
            <div class="modal-body">
                <div class="search-user">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">@</span>
                        <input type="text" class="form-control" name="search" id="search-user" placeholder="Search...">
                    </div>
                </div>
                <div class="search-result">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Add</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).on('keyup', '#search-user', function (){
        $('.search-result').html('');
        var key = $(this);
        if(key.val().length > 2){
            $.ajax({
                type: 'POST',
                url: base_url + "chat/search",
                data: {
                    keyword: key.val(),
                },
                dataType: "json",
                success: function(data) {
                    if(data.status == true){
                        $('.search-result').html(data.msg);
                    }else {
                        $('.search-result').html('<h2>No Match Found</h2>');
                    }
                }
            });
        }
    });

    $('.search-result').on('click', 'a', function(event) {
        sessionStorage.setItem('user_id', $(this).data('id'));
    });

    $('.modal-footer button.btn-primary').on("click", function() {
        let id = sessionStorage.getItem('user_id');
        if(id == 0){
            alertMsg('Please select user first');
        }else {
            $.ajax({
                type: 'POST',
                url: base_url + "chat/addNewChatUser",
                data: {
                    user_id: id,
                },
                dataType: "json",
                success: function(data) {
                    alertMsg(data.msg);
                }
            });
        }
        sessionStorage.removeItem('user_id');
    });

    $(document).ready(function() {
        setTimeout(function() {
            getList();
        }, 500);
    });

    function getList(){
        let div = $('.users div.user-list');
        div.html('');
        $.ajax({
            type: 'POST',
            url: base_url + "chat/loadUsers",
            dataType: "json",
            success: function(data) {
                if(data.status == true){
                    div.html(data.msg);
                }else {
                    div.html('<h2>No Match Found</h2>');
                }
            }
        });
    }

    // get chat
    sessionStorage.removeItem('receiver_id');
    $('.users div.user-list').on('click', 'a', function(event) {
        sessionStorage.removeItem('receiver_id');
        var id = $(this).data('id');
        sessionStorage.setItem('receiver_id', id);
        console.log(sessionStorage.getItem('receiver_id'));
        $('.msger-input').removeAttr('disabled');
        $('.msger-input').removeAttr('readonly');
        $.ajax({
            type: 'POST',
            url: base_url + "chat/loadUserChat",
            data: {
                rcv_id: id,
            },
            dataType: "json",
            success: function(data) {
                let html = '';
                data.forEach(element => {
                    html += `
                        <div class="msg right-msg">
                        <div class="msg-img" style="background-image: url(https://image.flaticon.com/icons/svg/145/145867.svg)"></div>

                        <div class="msg-bubble">
                            <div class="msg-info">
                            <div class="msg-info-name"></div>
                            <div class="msg-info-time">${element.created_at}</div>
                            </div>

                            <div class="msg-text">${element.msg}</div>
                        </div>
                        </div>
                    `;
                });
                $('.msger-chat').html(html);
            }
        });
    });

    const msgerForm = get(".msger-inputarea");
    const msgerInput = get(".msger-input");
    const msgerChat = get(".msger-chat");

    const BOT_MSGS = [
        "Hi, how are you?",
        "Ohh... I can't understand what you trying to say. Sorry!",
        "I like to play games... But I don't know how to play!",
        "Sorry if my answers are not relevant. :))",
        "I feel sleepy! :("
    ];

    // Icons made by Freepik from www.flaticon.com
    const BOT_IMG = "https://image.flaticon.com/icons/svg/327/327779.svg";
    const PERSON_IMG = "https://image.flaticon.com/icons/svg/145/145867.svg";
    const BOT_NAME = "BOT";
    const PERSON_NAME = "Sajad";

    msgerForm.addEventListener("submit", event => {
        event.preventDefault();

        const msgText = msgerInput.value;
        if(msgText.length == 0){
            alert('Please write some message');
        }
        if (!msgText) return;

        appendMessage(PERSON_NAME, PERSON_IMG, "right", msgText);
        msgerInput.value = "";

        // botResponse();
    });

    function appendMessage(name, img, side, text) {
        var rec_id = sessionStorage.getItem('receiver_id');
        if(rec_id !== null){
            $.ajax({
                type: 'POST',
                url: base_url + "chat/LoadChat",
                data: {
                    rcv_id: rec_id,
                    'message': text,
                    'time': formatDate(new Date()),
                },
                dataType: "json",
                success: function(data) {
                }
            });
        //   Simple solution for small apps
        const msgHTML = `
            <div class="msg ${side}-msg">
            <div class="msg-img" style="background-image: url(${img})"></div>

            <div class="msg-bubble">
                <div class="msg-info">
                <div class="msg-info-name"></div>
                <div class="msg-info-time">${formatDate(new Date())}</div>
                </div>

                <div class="msg-text">${text}</div>
            </div>
            </div>
        `;

        msgerChat.insertAdjacentHTML("beforeend", msgHTML);
        msgerChat.scrollTop += 500;
        }else {
            $('.msger-inputarea .msger-input').attr('disabled', 'true');
            $('.msger-inputarea .msger-input').attr('readonly', 'true');
            alert('Please select the user first');
        }
    }

    function botResponse() {
        const r = random(0, BOT_MSGS.length - 1);
        const msgText = BOT_MSGS[r];
        const delay = msgText.split(" ").length * 100;

        setTimeout(() => {
            appendMessage(BOT_NAME, BOT_IMG, "left", msgText);
        }, delay);
    }

    // Utils
    function get(selector, root = document) {
        return root.querySelector(selector);
    }

    function formatDate(date) {
        const h = "0" + date.getHours();
        const m = "0" + date.getMinutes();

        return `${h.slice(-2)}:${m.slice(-2)}`;
    }

    function random(min, max) {
        return Math.floor(Math.random() * (max - min) + min);
    }
</script>