<?php
$base_url = Flight::get('base_url');
$lastConversations = $lastConversation;
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages & Communication - Modern Bootstrap Admin</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Real-time messaging and communication center with chat interface">
    <meta name="keywords" content="bootstrap, admin, dashboard, messages, chat, communication">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="./assets/favicon-CvUZKS4z.svg">
    <link rel="icon" type="image/png" href="./assets/favicon-B_cwPWBd.png">

    <!-- PWA Manifest -->
    <link rel="manifest" href="./assets/manifest-DTaoG9pG.json">

    <!-- Preload critical fonts -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        as="style">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script type="module" crossorigin src="./assets/vendor-bootstrap-C9iorZI5.js"></script>
    <script type="module" crossorigin src="./assets/vendor-charts-DGwYAWel.js"></script>
    <script type="module" crossorigin src="./assets/vendor-ui-CflGdlft.js"></script>
    <script type="module" crossorigin src="./assets/main-DwHigVru.js"></script>
    <script type="module" crossorigin src="./assets/messages-ByGNYy7N.js"></script>
    <link rel="stylesheet" crossorigin href="./assets/main-QD_VOj1Y.css">
</head>

<body data-page="messages" class="messages-page">
    <!-- Admin App Container -->
    <div class="admin-app">
        <div class="admin-wrapper" id="admin-wrapper">

            <!-- Header -->
            <header class="admin-header">
                <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                    <div class="container-fluid">
                        <!-- Logo/Brand -->
                        <a class="navbar-brand d-flex align-items-center" href="./index.html">
                            <img src="data:image/svg+xml,%3csvg%20width='32'%20height='32'%20viewBox='0%200%2032%2032'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3c!--%20Background%20circle%20for%20the%20M%20--%3e%3ccircle%20cx='16'%20cy='16'%20r='16'%20fill='url(%23logoGradient)'/%3e%3c!--%20Centered%20Letter%20M%20--%3e%3cpath%20d='M10%2024V8h2.5l2.5%206.5L17.5%208H20v16h-2V12.5L16.5%2020h-1L14%2012.5V24H10z'%20fill='white'%20font-weight='700'/%3e%3c!--%20Gradient%20definition%20--%3e%3cdefs%3e%3clinearGradient%20id='logoGradient'%20x1='0%25'%20y1='0%25'%20x2='100%25'%20y2='100%25'%3e%3cstop%20offset='0%25'%20style='stop-color:%236366f1;stop-opacity:1'%20/%3e%3cstop%20offset='100%25'%20style='stop-color:%238b5cf6;stop-opacity:1'%20/%3e%3c/linearGradient%3e%3c/defs%3e%3c/svg%3e"
                                alt="Logo" height="32" class="d-inline-block align-text-top me-2">
                            <h1 class="h4 mb-0 fw-bold text-primary">Metis</h1>
                        </a>

                        <!-- Search Bar -->
                        <!-- Search Bar with Alpine.js -->
                        <div class="search-container flex-grow-1 mx-4" x-data="searchComponent">
                            <div class="position-relative">
                                <input type="search" class="form-control" placeholder="Search... (Ctrl+K)"
                                    x-model="query" @input="search()" data-search-input aria-label="Search">
                                <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3"></i>

                                <!-- Search Results Dropdown -->
                                <div x-show="results.length > 0" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    class="position-absolute top-100 start-0 w-100 bg-white border rounded-2 shadow-lg mt-1 z-3">
                                    <template x-for="result in results" :key="result.title">
                                        <a :href="result.url"
                                            class="d-block px-3 py-2 text-decoration-none text-dark border-bottom">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-file-text me-2 text-muted"></i>
                                                <span x-text="result.title"></span>
                                                <small class="ms-auto text-muted" x-text="result.type"></small>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side Icons -->
                        <div class="navbar-nav flex-row">
                            <!-- Theme Toggle with Alpine.js -->
                            <div x-data="themeSwitch">
                                <button class="btn btn-outline-secondary me-2" type="button" @click="toggle()"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="Toggle theme">
                                    <i class="bi bi-sun-fill" x-show="currentTheme === 'light'"></i>
                                    <i class="bi bi-moon-fill" x-show="currentTheme === 'dark'"></i>
                                </button>
                            </div>

                            <!-- Fullscreen Toggle -->
                            <button class="btn btn-outline-secondary me-2" type="button" data-fullscreen-toggle
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Toggle fullscreen">
                                <i class="bi bi-arrows-fullscreen icon-hover"></i>
                            </button>

                            <!-- Notifications -->
                            <div class="dropdown me-2">
                                <button class="btn btn-outline-secondary position-relative" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-bell"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <h6 class="dropdown-header">Notifications</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">New user registered</a></li>
                                    <li><a class="dropdown-item" href="#">Server status update</a></li>
                                    <li><a class="dropdown-item" href="#">New message received</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-center" href="#">View all notifications</a></li>
                                </ul>
                            </div>

                            <!-- User Menu -->
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary d-flex align-items-center" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="data:image/svg+xml,%3csvg%20width='32'%20height='32'%20viewBox='0%200%2032%2032'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3c!--%20Background%20circle%20--%3e%3ccircle%20cx='16'%20cy='16'%20r='16'%20fill='url(%23avatarGradient)'/%3e%3c!--%20Person%20silhouette%20--%3e%3cg%20fill='white'%20opacity='0.9'%3e%3c!--%20Head%20--%3e%3ccircle%20cx='16'%20cy='12'%20r='5'/%3e%3c!--%20Body%20--%3e%3cpath%20d='M16%2018c-5.5%200-10%202.5-10%207v1h20v-1c0-4.5-4.5-7-10-7z'/%3e%3c/g%3e%3c!--%20Subtle%20border%20--%3e%3ccircle%20cx='16'%20cy='16'%20r='15.5'%20fill='none'%20stroke='rgba(255,255,255,0.2)'%20stroke-width='1'/%3e%3c!--%20Gradient%20definition%20--%3e%3cdefs%3e%3clinearGradient%20id='avatarGradient'%20x1='0%25'%20y1='0%25'%20x2='100%25'%20y2='100%25'%3e%3cstop%20offset='0%25'%20style='stop-color:%236b7280;stop-opacity:1'%20/%3e%3cstop%20offset='100%25'%20style='stop-color:%234b5563;stop-opacity:1'%20/%3e%3c/linearGradient%3e%3c/defs%3e%3c/svg%3e"
                                        alt="User Avatar" width="24" height="24" class="rounded-circle me-2">
                                    <span class="d-none d-md-inline">John Doe</span>
                                    <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#"><i
                                                class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>

            <!-- Sidebar -->
            <aside class="admin-sidebar" id="admin-sidebar">
                <div class="sidebar-content">
                    <nav class="sidebar-nav">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="./users.html">
                                    <i class="bi bi-people"></i>
                                    <span>Users</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="./messages.html">
                                    <i class="bi bi-chat-dots"></i>
                                    <span>Messages</span>
                                    <span class="badge bg-primary rounded-pill ms-auto">Active</span>
                                </a>
                            </li>
                            <li class="nav-item mt-3">
                                <small class="text-muted px-3 text-uppercase fw-bold">Admin</small>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./settings.html">
                                    <i class="bi bi-gear"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./security.html">
                                    <i class="bi bi-shield-check"></i>
                                    <span>Security</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./help.html">
                                    <i class="bi bi-question-circle"></i>
                                    <span>Help & Support</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <!-- Floating Hamburger Menu -->
            <button class="hamburger-menu" type="button" data-sidebar-toggle aria-label="Toggle sidebar">
                <i class="bi bi-list"></i>
            </button>

            <!-- Main Content -->
            <main class="admin-main">
                <div class="container-fluid p-4 p-lg-4">

                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h1 class="h3 mb-0">Messages</h1>
                            <p class="text-muted mb-0">Real-time communication center</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary d-lg-none" @click="toggleSidebar()">
                                <i class="bi bi-list me-2"></i>Conversations
                            </button>
                            <button type="button" class="btn btn-outline-secondary" @click="markAllRead()">
                                <i class="bi bi-check-all me-2"></i>Mark All Read
                            </button>
                            <button type="button" class="btn btn-primary" @click="newConversation()">
                                <i class="bi bi-plus-lg me-2"></i>New Message
                            </button>
                        </div>
                    </div>

                    <!-- Messages Container -->
                    <div x-data="messagesComponent" x-init="init()" class="messages-container">
                        <div class="messages-layout">

                            <!-- Conversations Sidebar -->
                            <div class="messages-sidebar" :class="{ 'mobile-show': sidebarVisible }">
                                <!-- Sidebar Header -->
                                <div class="messages-header">
                                    <h5 class="header-title mb-0">Messages</h5>
                                    <div class="d-flex gap-2 mt-3">
                                        <div class="search-container flex-grow-1">
                                            <input type="search" class="form-control"
                                                placeholder="Search conversations..." x-model="searchQuery"
                                                @input="filterConversations()">
                                            <i class="bi bi-search search-icon"></i>
                                        </div>
                                        <button class="btn btn-primary btn-sm" @click="newConversation()"
                                            title="New Message">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Conversations List -->
                                <div class="conversations-list">
                                    <?php if (!empty($lastConversations)): ?>
                                        <?php foreach ($lastConversations as $lastConversation): ?>
                                            <a href="#"
                                                class="conversation-item <?= ($lastConversation['unread'] > 0) ? 'unread' : '' ?>"
                                                @click.prevent="selectConversation({
                                                   id: <?= $lastConversation['id'] ?>,
                                                   name: '<?= htmlspecialchars($lastConversation['name']) ?>',
                                                   avatar: 'data:image/svg+xml,%3csvg%20width=\'32\'%20height=\'32\'%20viewBox=\'0%200%2032%2032\'%20fill=\'none\'%20xmlns=\'http://www.w3.org/2000/svg\'%3e%3ccircle%20cx=\'16\'%20cy=\'16\'%20r=\'16\'%20fill=\'url(%23avatarGradient)\'/%3e%3cg%20fill=\'white\'%20opacity=\'0.9\'%3e%3ccircle%20cx=\'16\'%20cy=\'12\'%20r=\'5\'/%3e%3cpath%20d=\'M16%2018c-5.5%200-10%202.5-10%207v1h20v-1c0-4.5-4.5-7-10-7z\'/%3e%3c/g%3e%3c/svg%3e',
                                                   online: false,
                                                   lastMessage: 'Click to start conversation',
                                                   lastMessageTime: '',
                                                   type: 'direct',
                                                   unread: <?= $lastConversation['unread'] ?>
                                               })">
                                                <div class="conversation-avatar">
                                                    <img src="data:image/svg+xml,%3csvg%20width='32'%20height='32'%20viewBox='0%200%2032%2032'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3ccircle%20cx='16'%20cy='16'%20r='16'%20fill='url(%23avatarGradient)'/%3e%3cg%20fill='white'%20opacity='0.9'%3e%3ccircle%20cx='16'%20cy='12'%20r='5'/%3e%3cpath%20d='M16%2018c-5.5%200-10%202.5-10%207v1h20v-1c0-4.5-4.5-7-10-7z'/%3e%3c/g%3e%3c/svg%3e"
                                                        alt="<?= htmlspecialchars($lastConversation['name']) ?>">
                                                </div>
                                                <div class="conversation-info">
                                                    <div class="conversation-header">
                                                        <h6 class="conversation-name">
                                                            <?= htmlspecialchars($lastConversation['name']) ?>
                                                        </h6>
                                                        <span class="conversation-time"></span>
                                                    </div>
                                                    <p class="conversation-preview">
                                                        <?= $lastMessage = ($lastConversation['lastMessage'] != null) ? $lastConversation['lastMessage'] : "Click to start conversation" ?>
                                                    </p>
                                                    <div class="conversation-footer">
                                                        <span class="conversation-type">direct</span>
                                                        <?php if ($lastConversation['unread'] > 0): ?>
                                                            <span class="unread-badge"><?= $lastConversation['unread'] ?></span>
                                                        <?php endif ?>
                                                    </div>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="empty-conversations">
                                            <i class="bi bi-chat-dots"></i>
                                            <p>No users available</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="active-chat" x-show="selectedConversation">
                                <!-- Chat Header -->
                                <div class="chat-header">
                                    <div class="chat-user-info">
                                        <button class="btn btn-link d-lg-none me-2 p-0"
                                            @click="sidebarVisible = !sidebarVisible">
                                            <i class="bi bi-arrow-left fs-5"></i>
                                        </button>
                                        <div class="chat-avatar-container">
                                            <img :src="selectedConversation?.avatar" class="chat-avatar"
                                                :alt="selectedConversation?.name">
                                            <div class="online-indicator" x-show="selectedConversation?.online">
                                            </div>
                                        </div>
                                        <div class="chat-details">
                                            <h6 class="chat-name" x-text="selectedConversation?.name"></h6>
                                            <p class="chat-status" x-show="selectedConversation?.online">● Online
                                            </p>
                                            <p class="chat-status" x-show="!selectedConversation?.online"
                                                x-text="`Last seen ${selectedConversation?.lastSeen}`"></p>
                                        </div>
                                    </div>
                                    <div class="chat-actions">
                                        <button class="btn" @click="videoCall()" title="Video Call">
                                            <i class="bi bi-camera-video"></i>
                                        </button>
                                        <button class="btn" @click="voiceCall()" title="Voice Call">
                                            <i class="bi bi-telephone"></i>
                                        </button>
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                                title="More Options">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#"
                                                        @click.prevent="muteConversation()">
                                                        <i class="bi bi-bell-slash me-2"></i>Mute notifications
                                                    </a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        @click.prevent="archiveConversation()">
                                                        <i class="bi bi-archive me-2"></i>Archive chat
                                                    </a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item text-danger" href="#"
                                                        @click.prevent="deleteConversation()">
                                                        <i class="bi bi-trash me-2"></i>Delete chat
                                                    </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Messages Area -->
                                <div class="chat-messages" id="chatMessages">
                                    <!-- Date Separator -->
                                    <div class="date-separator">
                                        <span class="date-label">Today</span>
                                    </div>

                                    <!-- Messages -->
                                    <div class="message-group">
                                        <template x-for="message in currentMessages" :key="message.id">
                                            <div class="message" :class="{ 'own-message': message.sent }">
                                                <img x-show="!message.sent" :src="selectedConversation?.avatar"
                                                    class="message-avatar" :alt="selectedConversation?.name">
                                                <div class="message-bubble">
                                                    <div class="message-content">
                                                        <p x-text="message.text"></p>
                                                    </div>
                                                    <div class="message-info">
                                                        <span class="message-time" x-text="message.time"></span>
                                                        <span x-show="message.sent" class="message-status">
                                                            <i class="bi bi-check-all" x-show="message.read"></i>
                                                            <i class="bi bi-check" x-show="!message.read"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                    <!-- Typing Indicator -->
                                    <div class="typing-indicator" x-show="isTyping">
                                        <img :src="selectedConversation?.avatar" class="typing-avatar"
                                            :alt="selectedConversation?.name">
                                        <div class="typing-content">
                                            <div class="typing-dots">
                                                <div class="dot"></div>
                                                <div class="dot"></div>
                                                <div class="dot"></div>
                                            </div>
                                            <span class="typing-text">typing...</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Message Input -->
                                <div class="chat-input">
                                    <div class="input-container">
                                        <div class="input-actions">
                                            <button class="btn" @click="toggleAttachment()" title="Attach file">
                                                <i class="bi bi-paperclip"></i>
                                            </button>
                                        </div>
                                        <div class="message-input">
                                            <textarea class="form-control" placeholder="Type a message..." rows="1"
                                                x-model="newMessage" @keydown.enter.prevent="sendMessage()"
                                                @input="handleTyping(); autoResize($event)"
                                                style="resize: none;"></textarea>
                                        </div>
                                        <div class="input-actions">
                                            <button class="btn" @click="toggleEmojiPicker()" title="Add emoji">
                                                <i class="bi bi-emoji-smile"></i>
                                            </button>
                                            <button class="btn btn-primary" @click="sendMessage()"
                                                :disabled="!newMessage.trim()" title="Send message">
                                                <i class="bi bi-send"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Emoji Picker -->
                                    <div class="emoji-picker" x-show="showEmojiPicker" x-transition>
                                        <div class="emoji-grid">
                                            <template x-for="emoji in emojis" :key="emoji">
                                                <button class="emoji-btn" @click="addEmoji(emoji)"
                                                    x-text="emoji"></button>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Empty Chat State -->
                            <div class="empty-chat" x-show="!selectedConversation">
                                <div class="empty-icon">
                                    <i class="bi bi-chat-dots"></i>
                                </div>
                                <h5 class="empty-text">Select a conversation to start messaging</h5>
                                <p class="text-muted mb-4">Choose from your existing conversations or start a new
                                    one</p>
                                <button class="btn btn-primary" @click="newConversation()">
                                    <i class="bi bi-plus-lg me-2"></i>Start New Conversation
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

        </div>
        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-0 text-muted">© 2025 Modern Bootstrap Admin Template</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-0 text-muted">Built with Bootstrap 5.3.7</p>
                    </div>
                </div>
            </div>
        </footer>

    </div> <!-- /.admin-wrapper -->
    </div>

    <!-- Page-specific Component -->

    <!-- Main App Script -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButton = document.querySelector('[data-sidebar-toggle]');
            const wrapper = document.getElementById('admin-wrapper');

            if (toggleButton && wrapper) {
                const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
                if (isCollapsed) {
                    wrapper.classList.add('sidebar-collapsed');
                    toggleButton.classList.add('is-active');
                }

                toggleButton.addEventListener('click', () => {
                    const isCurrentlyCollapsed = wrapper.classList.contains('sidebar-collapsed');

                    if (isCurrentlyCollapsed) {
                        wrapper.classList.remove('sidebar-collapsed');
                        toggleButton.classList.remove('is-active');
                        localStorage.setItem('sidebar-collapsed', 'false');
                    } else {
                        wrapper.classList.add('sidebar-collapsed');
                        toggleButton.classList.add('is-active');
                        localStorage.setItem('sidebar-collapsed', 'true');
                    }
                });
            }
        });
    </script>
</body>

</html>