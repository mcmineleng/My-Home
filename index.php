<?php
// 读取JSON数据函数
function readJsonData($filename) {
    if (!file_exists($filename)) {
        return null;
    }
    
    $jsonData = file_get_contents($filename);
    if ($jsonData === false) {
        return null;
    }
    
    $data = json_decode($jsonData, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        return null;
    }
    
    return $data;
}

// 获取Font Awesome图标类名
function getIcon($iconValue) {
    $iconMap = [
        '$email' => 'fas fa-envelope',
        '$phone' => 'fas fa-phone',
        '$qq' => 'fab fa-qq',
        '$weibo' => 'fab fa-weibo',
        '$notice' => 'fas fa-bell',
        '$mobile' => 'fas fa-mobile-alt',
        '$wechat' => 'fab fa-weixin',
        '$blog' => 'fas fa-blog',
        '$bbs' => 'fas fa-users',
        '$github' => 'fab fa-github',
        '$codepen' => 'fab fa-codepen',
        '$globe' => 'fas fa-globe',
        '$briefcase' => 'fas fa-briefcase',
        '$book' => 'fas fa-book',
        '$handshake' => 'fas fa-handshake'
    ];
    
    if (isset($iconMap[$iconValue])) {
        return $iconMap[$iconValue];
    }
    
    return '';
}

// 渲染图标
function renderIcon($iconValue) {
    $faIcon = getIcon($iconValue);
    
    if (!empty($faIcon)) {
        return '<i class="' . $faIcon . '"></i>';
    } else {
        return '<img src="' . htmlspecialchars($iconValue) . '" alt="图标">';
    }
}

// 主程序 - 读取数据
$jsonFile = './data/data.json';
$data = readJsonData($jsonFile);
$pageTitle = isset($data['name']) ? $data['name'] . ' - 个人主页' : '个人主页';

// 获取头像URL用于Favicon
$avatarForFavicon = isset($data['avatar']) && !empty($data['avatar']) ? 
    $data['avatar'] : 
    'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1160&q=80';

if ($data === null) {
    $errorMessage = '无法读取数据文件，请检查 data/data.json 文件是否存在且格式正确。';
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- 动态设置Favicon，与头像保持一致 -->
    <link rel="icon" href="<?php echo htmlspecialchars($avatarForFavicon); ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?php echo htmlspecialchars($avatarForFavicon); ?>" type="image/x-icon">
    <!-- 为不同尺寸设备提供优化 -->
    <link rel="apple-touch-icon" href="<?php echo htmlspecialchars($avatarForFavicon); ?>">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: -1;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 25px;
            margin-bottom: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
        }
        
        .profile-section {
            display: flex;
            flex-direction: column;
            margin-bottom: 30px;
            position: relative;
        }
        
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .avatar-container {
            margin-right: 20px;
            flex-shrink: 0;
        }
        
        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 20px;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 0 5px rgba(255, 255, 255, 0.2);
        }
        
        .name-title h1 {
            font-size: 2.2rem;
            margin-bottom: 5px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        
        .bio {
            font-size: 1.1rem;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .tag {
            background: rgba(255, 255, 255, 0.25);
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            color: #fff;
            backdrop-filter: blur(10px);
        }
        
        .contact-section, .content-section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 10px;
            font-size: 1.3rem;
        }
        
        .link-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .link-item {
            display: flex;
            align-items: center;
            padding: 18px;
            margin-bottom: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }
        
        /* 修复：确保最后一个链接项没有底部外边距 */
        .link-list .link-item:last-child {
            margin-bottom: 0;
        }
        
        .link-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }
        
        .link-icon {
            width: 44px;
            height: 44px;
            margin-right: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            font-size: 1.3rem;
            flex-shrink: 0; /* 防止图标被压缩 */
        }
        
        .link-icon img {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }
        
        .link-content {
            flex: 1;
            min-width: 0; /* 防止文本溢出 */
        }
        
        .link-title {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 1.1rem;
            line-height: 1.3; /* 优化行高 */
        }
        
        .link-desc {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.4; /* 优化行高 */
        }
        
        .link-arrow {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.2rem;
            flex-shrink: 0; /* 防止箭头被压缩 */
            margin-left: 10px;
        }
        
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: row;
                align-items: center;
            }
            
            .avatar-container {
                margin-right: 15px;
                margin-bottom: 0;
            }
            
            .avatar {
                width: 80px;
                height: 80px;
            }
            
            .name-title h1 {
                font-size: 1.8rem;
            }
            
            .link-item {
                padding: 15px;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 15px 10px;
            }
            
            .glass-card {
                padding: 20px;
            }
            
            .link-item {
                padding: 12px;
            }
            
            .link-icon {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
                margin-right: 12px;
            }
            
            .avatar {
                width: 70px;
                height: 70px;
            }
            
            .name-title h1 {
                font-size: 1.6rem;
            }
        }
        
        a, button, .link-item {
            -webkit-tap-highlight-color: transparent;
            outline: none;
        }
        
        a:focus, button:focus, .link-item:focus {
            outline: none;
        }
        
        footer {
            text-align: center;
            padding: 30px 0 20px;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .error-message {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.3);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($errorMessage)): ?>
            <div class="error-message">
                <h3>错误：无法读取数据文件</h3>
                <p><?php echo $errorMessage; ?></p>
            </div>
        <?php else: ?>
        
            <!-- 个人信息区域 -->
            <div class="glass-card profile-section">
                <div class="profile-header">
                    <div class="avatar-container">
                        <?php if (isset($data['avatar']) && !empty($data['avatar'])): ?>
                            <img src="<?php echo htmlspecialchars($data['avatar']); ?>" alt="头像" class="avatar">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1160&q=80" alt="默认头像" class="avatar">
                        <?php endif; ?>
                    </div>
                    <div class="name-title">
                        <h1><?php echo htmlspecialchars($data['name'] ?? '姓名'); ?></h1>
                    </div>
                </div>
                <p class="bio"><?php echo htmlspecialchars($data['description'] ?? '个人描述'); ?></p>
                <div class="tags">
                    <?php if (isset($data['tag']) && is_array($data['tag'])): ?>
                        <?php foreach ($data['tag'] as $tag): ?>
                            <span class="tag"><?php echo htmlspecialchars($tag); ?></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- 联系方式区域 -->
            <?php if (isset($data['contact']) && is_array($data['contact']) && count($data['contact']) > 0): ?>
            <div class="contact-section">
                <h2 class="section-title"><i class="fas fa-address-book"></i> 联系方式</h2>
                <div class="glass-card">
                    <ul class="link-list">
                        <?php foreach ($data['contact'] as $contact): ?>
                        <a href="<?php echo htmlspecialchars($contact['url'] ?? '#'); ?>" class="link-item">
                            <div class="link-icon">
                                <?php echo renderIcon($contact['icon'] ?? '$email'); ?>
                            </div>
                            <div class="link-content">
                                <div class="link-title"><?php echo htmlspecialchars($contact['title'] ?? '标题'); ?></div>
                                <div class="link-desc"><?php echo htmlspecialchars($contact['text'] ?? '描述'); ?></div>
                            </div>
                            <div class="link-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- 个人网站区域 -->
            <?php if (isset($data['myweb']) && is_array($data['myweb']) && count($data['myweb']) > 0): ?>
            <div class="content-section">
                <h2 class="section-title"><i class="fas fa-globe"></i> 个人网站</h2>
                <div class="glass-card">
                    <ul class="link-list">
                        <?php foreach ($data['myweb'] as $website): ?>
                        <a href="<?php echo htmlspecialchars($website['url'] ?? '#'); ?>" target="_blank" class="link-item">
                            <div class="link-icon">
                                <?php echo renderIcon($website['icon'] ?? '$blog'); ?>
                            </div>
                            <div class="link-content">
                                <div class="link-title"><?php echo htmlspecialchars($website['title'] ?? '网站标题'); ?></div>
                                <div class="link-desc"><?php echo htmlspecialchars($website['text'] ?? '网站描述'); ?></div>
                            </div>
                            <div class="link-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- 友情链接区域 -->
            <?php if (isset($data['friendlink']) && is_array($data['friendlink']) && count($data['friendlink']) > 0): ?>
            <div class="content-section">
                <h2 class="section-title"><i class="fas fa-handshake"></i> 友情链接</h2>
                <div class="glass-card">
                    <ul class="link-list">
                        <?php foreach ($data['friendlink'] as $friend): ?>
                        <a href="<?php echo htmlspecialchars($friend['url'] ?? '#'); ?>" target="_blank" class="link-item">
                            <div class="link-icon">
                                <?php echo renderIcon($friend['icon'] ?? '$handshake'); ?>
                            </div>
                            <div class="link-content">
                                <div class="link-title"><?php echo htmlspecialchars($friend['title'] ?? '友情链接'); ?></div>
                                <div class="link-desc"><?php echo htmlspecialchars($friend['text'] ?? '链接描述'); ?></div>
                            </div>
                            <div class="link-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            
        <?php endif; ?>
        
        <footer>
            <p>© 2025 <?php echo htmlspecialchars($data['name'] ?? '个人'); ?>的主页 | 最后更新: <?php echo date('Y年m月d日'); ?></p>
        </footer>
    </div>

    <script>
        document.querySelectorAll('.link-item').forEach(link => {
            link.addEventListener('click', function(e) {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });
        
        document.querySelectorAll('a[href^="http"]').forEach(link => {
            if (!link.getAttribute('target') && !link.href.includes(window.location.hostname)) {
                link.setAttribute('target', '_blank');
            }
        });
    </script>
</body>
</html>
