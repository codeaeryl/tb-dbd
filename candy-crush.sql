-- Candy Crush Database Schema with Dummy Data
-- Created: 2025-05-24

-- Create the database
CREATE DATABASE IF NOT EXISTS candy_crush_db;
USE candy_crush_db;

-- Players Table
CREATE TABLE players (
    player_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    display_name VARCHAR(50),
    profile_picture VARCHAR(255),
    registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_login DATETIME,
    current_level INT DEFAULT 1,
    current_score INT DEFAULT 0,
    coins_balance INT DEFAULT 0,
    lives_remaining INT DEFAULT 5,
    last_life_refill DATETIME,
    is_active BOOLEAN DEFAULT TRUE,
    is_premium BOOLEAN DEFAULT FALSE
);

-- Insert 5 players with realistic data
INSERT INTO players (username, email, password_hash, display_name, profile_picture, last_login, current_level, current_score, coins_balance, lives_remaining, last_life_refill, is_premium) VALUES
('sweet_crusher', 'sweet.crusher@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sugar Queen', 'profile1.jpg', '2025-05-23 14:30:45', 3, 4500, 125, 3, '2025-05-24 08:00:00', TRUE),
('candy_king', 'king.candy@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'King Candy', 'profile2.jpg', '2025-05-24 09:15:22', 5, 7800, 320, 5, '2025-05-24 12:30:00', TRUE),
('jelly_queen', 'jelly.queen@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jelly Queen', 'profile3.jpg', '2025-05-22 18:45:10', 2, 2100, 75, 2, '2025-05-24 07:30:00', FALSE),
('choco_lover', 'choco.lover@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Choco Master', 'profile4.jpg', '2025-05-24 10:05:33', 1, 500, 25, 5, '2025-05-24 10:00:00', FALSE),
('fruit_ninja', 'fruit.ninja@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Fruit Ninja', 'profile5.jpg', '2025-05-23 22:10:15', 4, 6200, 180, 4, '2025-05-24 09:45:00', TRUE);

-- Friendships Table
CREATE TABLE friendships (
    friendship_id INT PRIMARY KEY AUTO_INCREMENT,
    player1_id INT NOT NULL,
    player2_id INT NOT NULL,
    status ENUM('pending', 'accepted', 'blocked') DEFAULT 'accepted',
    friendship_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (player1_id) REFERENCES players(player_id) ON DELETE CASCADE,
    FOREIGN KEY (player2_id) REFERENCES players(player_id) ON DELETE CASCADE,
    CHECK (player1_id < player2_id),
    UNIQUE (player1_id, player2_id)
);

-- Insert 5 friendships with unique player combinations
INSERT INTO friendships (player1_id, player2_id, status, friendship_date) VALUES
(1, 2, 'accepted', '2025-05-10 08:15:00'),
(1, 3, 'accepted', '2025-05-12 14:30:00'),
(2, 4, 'accepted', '2025-05-15 09:45:00'),
(3, 5, 'accepted', '2025-05-18 16:20:00'),
(4, 5, 'accepted', '2025-05-20 11:10:00');

-- Levels Table
CREATE TABLE levels (
    level_id INT PRIMARY KEY,
    level_name VARCHAR(50) NOT NULL,
    difficulty INT NOT NULL,
    moves_allowed INT NOT NULL,
    target_score INT NOT NULL,
    required_stars INT DEFAULT 0,
    required_jellies INT NOT NULL,
    color VARCHAR(10),
    required_color INT DEFAULT 0
);

-- Insert 5 levels with realistic game data
INSERT INTO levels (level_id, level_name, difficulty, moves_allowed, target_score, required_stars, required_jellies, color, required_color) VALUES
(1, 'Sweet Beginnings', 1, 25, 1000, 1, 10, 'blue', 15),
(2, 'Chocolate Falls', 2, 20, 1500, 1, 15, 'purple', 20),
(3, 'Jelly Jungle', 3, 18, 2000, 1, 20, 'yellow', 25),
(4, 'Licorice Labyrinth', 4, 15, 2500, 2, 25, 'red', 30),
(5, 'Candy Kingdom', 5, 12, 3000, 2, 30, 'green', 35);

-- Player Progress Table
CREATE TABLE player_progress (
    progress_id INT PRIMARY KEY AUTO_INCREMENT,
    player_id INT NOT NULL,
    level_id INT NOT NULL,
    highest_score INT DEFAULT 0,
    stars_earned INT DEFAULT 0,
    times_played INT DEFAULT 0,
    times_completed INT DEFAULT 0,
    best_time INT,
    is_unlocked BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (player_id) REFERENCES players(player_id) ON DELETE CASCADE,
    FOREIGN KEY (level_id) REFERENCES levels(level_id) ON DELETE CASCADE,
    UNIQUE (player_id, level_id)
);

-- Insert 15 player progress records (3 per player, sequential levels)
INSERT INTO player_progress (player_id, level_id, highest_score, stars_earned, times_played, times_completed, best_time, is_unlocked) VALUES
-- Player 1 (current_level = 3)
(1, 1, 1200, 3, 5, 3, 120, TRUE),
(1, 2, 1800, 2, 8, 5, 180, TRUE),
(1, 3, 2200, 1, 12, 7, 240, TRUE),
-- Player 2 (current_level = 5)
(2, 1, 1500, 3, 3, 3, 90, TRUE),
(2, 2, 2000, 3, 5, 5, 150, TRUE),
(2, 3, 2500, 2, 7, 6, 210, TRUE),
(2, 4, 2800, 2, 10, 8, 270, TRUE),
(2, 5, 3200, 1, 15, 10, 330, TRUE),
-- Player 3 (current_level = 2)
(3, 1, 1100, 2, 7, 5, 140, TRUE),
(3, 2, 1600, 1, 10, 7, 200, TRUE),
-- Player 4 (current_level = 1)
(4, 1, 800, 1, 10, 5, 180, TRUE),
-- Player 5 (current_level = 4)
(5, 1, 1300, 3, 4, 4, 100, TRUE),
(5, 2, 1900, 2, 6, 6, 170, TRUE),
(5, 3, 2300, 2, 8, 7, 220, TRUE),
(5, 4, 2700, 1, 12, 9, 290, TRUE);

-- Items Table (In-game items)
CREATE TABLE items (
    item_id INT PRIMARY KEY AUTO_INCREMENT,
    item_name VARCHAR(50) NOT NULL,
    item_type ENUM('booster', 'lives', 'coins', 'powerup') NOT NULL,
    description TEXT,
    base_price INT,
    is_purchasable BOOLEAN DEFAULT TRUE,
    image_url VARCHAR(255)
);

-- Insert 5 in-game items
INSERT INTO items (item_name, item_type, description, base_price, is_purchasable, image_url) VALUES
('Color Bomb', 'booster', 'Clears all candies of one color when used', 500, TRUE, 'color_bomb.jpg'),
('Extra Moves', 'powerup', 'Adds 5 extra moves to your level', 300, TRUE, 'extra_moves.jpg'),
('Lollipop Hammer', 'powerup', 'Destroys one candy of your choice', 200, TRUE, 'lollipop_hammer.jpg'),
('5 Lives Pack', 'lives', 'Gives you 5 additional lives', 1000, TRUE, 'lives_pack.jpg'),
('100 Coins', 'coins', 'Gives you 100 coins to spend in the game', 199, TRUE, 'coins_pack.jpg');

-- Inventory Table (player-stored items)
CREATE TABLE inventory (
    inventory_id INT PRIMARY KEY AUTO_INCREMENT,
    player_id INT NOT NULL,
    item_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    last_updated DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (player_id) REFERENCES players(player_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES items(item_id) ON DELETE CASCADE,
    UNIQUE (player_id, item_id)
);

-- Insert inventory data (5 items per player)
INSERT INTO inventory (player_id, item_id, quantity, last_updated) VALUES
-- Player 1 (sweet_crusher)
(1, 1, 3, '2025-05-24 10:15:00'),  -- 3 Color Bombs
(1, 2, 5, '2025-05-24 09:30:00'),  -- 5 Extra Moves
(1, 3, 2, '2025-05-23 18:45:00'),  -- 2 Lollipop Hammers
(1, 4, 0, '2025-05-22 14:20:00'),  -- 0 Lives Packs (used up)
(1, 5, 150, '2025-05-24 08:00:00'), -- 150 Coins

-- Player 2 (candy_king)
(2, 1, 5, '2025-05-24 11:30:00'),  -- 5 Color Bombs
(2, 2, 8, '2025-05-24 10:45:00'),  -- 8 Extra Moves
(2, 3, 4, '2025-05-23 19:15:00'),  -- 4 Lollipop Hammers
(2, 4, 2, '2025-05-23 12:00:00'),  -- 2 Lives Packs
(2, 5, 320, '2025-05-24 09:15:00'), -- 320 Coins

-- Player 3 (jelly_queen)
(3, 1, 1, '2025-05-24 08:45:00'),  -- 1 Color Bomb
(3, 2, 3, '2025-05-23 17:30:00'),  -- 3 Extra Moves
(3, 3, 1, '2025-05-22 16:15:00'),  -- 1 Lollipop Hammer
(3, 4, 1, '2025-05-21 11:45:00'),  -- 1 Lives Pack
(3, 5, 75, '2025-05-24 07:30:00'),  -- 75 Coins

-- Player 4 (choco_lover)
(4, 1, 0, '2025-05-23 14:00:00'),  -- 0 Color Bombs (none owned)
(4, 2, 2, '2025-05-22 13:15:00'),  -- 2 Extra Moves
(4, 3, 0, '2025-05-21 10:30:00'),  -- 0 Lollipop Hammers
(4, 4, 0, '2025-05-20 09:45:00'),  -- 0 Lives Packs
(4, 5, 25, '2025-05-24 06:15:00'),  -- 25 Coins

-- Player 5 (fruit_ninja)
(5, 1, 2, '2025-05-24 12:45:00'),  -- 2 Color Bombs
(5, 2, 4, '2025-05-24 11:00:00'),  -- 4 Extra Moves
(5, 3, 3, '2025-05-23 20:30:00'),  -- 3 Lollipop Hammers
(5, 4, 1, '2025-05-22 15:45:00'),  -- 1 Lives Pack
(5, 5, 180, '2025-05-24 10:30:00'); -- 180 Coins
-- Transactions Table
CREATE TABLE transactions (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    player_id INT NOT NULL,
    item_id INT,
    quantity INT NOT NULL DEFAULT 1,
    transaction_type ENUM('purchase', 'reward', 'gift', 'refund') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'USD',
    payment_method VARCHAR(50),
    transaction_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'completed',
    receipt_number VARCHAR(50),
    FOREIGN KEY (player_id) REFERENCES players(player_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES items(item_id) ON DELETE CASCADE
);

-- Insert 5 transactions (1 per player)
INSERT INTO transactions (player_id, item_id, quantity, transaction_type, amount, currency, payment_method, transaction_date, status, receipt_number) VALUES
(1, 4, 1, 'purchase', 4.99, 'USD', 'credit_card', '2025-05-15 10:30:00', 'completed', 'RCPT-10001'),
(2, 5, 1, 'purchase', 4.99, 'USD', 'paypal', '2025-05-16 14:45:00', 'completed', 'RCPT-10002'),
(3, 3, 1, 'purchase', 1.99, 'USD', 'google_play', '2025-05-17 18:20:00', 'completed', 'RCPT-10003'),
(4, 1, 1, 'purchase', 19.99, 'USD', 'apple_pay', '2025-05-18 09:15:00', 'completed', 'RCPT-10004'),
(5, 2, 1, 'purchase', 4.99, 'USD', 'credit_card', '2025-05-19 22:10:00', 'completed', 'RCPT-10005');

-- Game Sessions Table
CREATE TABLE game_sessions (
    session_id INT PRIMARY KEY AUTO_INCREMENT,
    player_id INT NOT NULL,
    level_id INT NOT NULL,
    start_time DATETIME DEFAULT CURRENT_TIMESTAMP,
    end_time DATETIME,
    score INT DEFAULT 0,
    moves_used INT DEFAULT 0,
    stars_earned INT DEFAULT 0,
    item_used INT,
    result ENUM('win', 'lose', 'quit') NOT NULL,
    FOREIGN KEY (player_id) REFERENCES players(player_id) ON DELETE CASCADE,
    FOREIGN KEY (level_id) REFERENCES levels(level_id) ON DELETE CASCADE,
    FOREIGN KEY (item_used) REFERENCES items(item_id) ON DELETE CASCADE
);

-- Player 1 Sessions (Level 1: 5 played, 3 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 3 wins (keeping highest scores)
(1, 1, '2025-05-21 10:15:00', '2025-05-21 10:30:45', 1200, 25, 3, 1, 'win'),
(1, 1, '2025-05-20 14:30:00', '2025-05-20 14:45:30', 950, 25, 2, 2, 'win'),
(1, 1, '2025-05-22 11:45:00', '2025-05-22 12:00:30', 1100, 25, 3, NULL, 'win'),
-- 2 losses
(1, 1, '2025-05-20 09:00:00', '2025-05-20 09:10:15', 800, 25, 0, NULL, 'lose'),
(1, 1, '2025-05-21 18:00:00', '2025-05-21 18:15:20', 900, 25, 0, NULL, 'lose');

-- Player 1 Sessions (Level 2: 8 played, 5 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 5 wins (keeping highest scores)
(1, 2, '2025-05-24 18:30:00', '2025-05-24 18:50:45', 1800, 20, 2, 2, 'win'),
(1, 2, '2025-05-22 13:30:00', '2025-05-22 13:50:15', 1400, 20, 1, NULL, 'win'),
(1, 2, '2025-05-23 12:30:00', '2025-05-23 12:50:20', 1600, 20, 2, 1, 'win'),
(1, 2, '2025-05-24 09:00:00', '2025-05-24 09:20:15', 1700, 20, 2, 3, 'win'),
(1, 2, '2025-05-22 19:15:00', '2025-05-22 19:35:30', 1500, 20, 1, 2, 'win'),
-- 3 losses
(1, 2, '2025-05-23 08:45:00', '2025-05-23 09:05:45', 1300, 20, 0, NULL, 'lose'),
(1, 2, '2025-05-23 16:15:00', '2025-05-23 16:35:30', 1450, 20, 0, NULL, 'lose'),
(1, 2, '2025-05-24 14:45:00', '2025-05-24 15:05:30', 1550, 20, 0, NULL, 'lose');

-- Player 1 Sessions (Level 3: 12 played, 7 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 7 wins (keeping highest scores)
(1, 3, '2025-05-28 13:15:00', '2025-05-28 13:40:30', 2200, 18, 1, 3, 'win'),
(1, 3, '2025-05-25 10:30:00', '2025-05-25 10:55:30', 2000, 18, 1, 2, 'win'),
(1, 3, '2025-05-26 13:45:00', '2025-05-26 14:10:15', 2100, 18, 1, 3, 'win'),
(1, 3, '2025-05-27 10:15:00', '2025-05-27 10:40:45', 2200, 18, 1, 2, 'win'),
(1, 3, '2025-05-28 09:30:00', '2025-05-28 09:55:15', 2150, 18, 1, NULL, 'win'),
(1, 3, '2025-05-24 19:15:00', '2025-05-24 19:40:15', 1900, 18, 1, NULL, 'win'),
(1, 3, '2025-05-26 09:15:00', '2025-05-26 09:40:30', 2050, 18, 1, NULL, 'win'),
-- 5 losses
(1, 3, '2025-05-25 14:45:00', '2025-05-25 15:10:45', 1850, 18, 0, NULL, 'lose'),
(1, 3, '2025-05-27 14:30:00', '2025-05-27 14:55:20', 2000, 18, 0, NULL, 'lose'),
(1, 3, '2025-05-27 17:45:00', '2025-05-27 18:10:30', 2100, 18, 0, 1, 'lose'),
(1, 3, '2025-05-25 17:30:00', '2025-05-25 17:55:20', 1950, 18, 0, 1, 'lose'),
(1, 3, '2025-05-27 12:15:00', '2025-05-27 12:40:45', 1900, 18, 0, 2, 'lose');

-- Player 2 Sessions (Level 1: 3 played, 3 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 3 wins (all completed)
(2, 1, '2025-05-20 10:45:00', '2025-05-20 11:00:45', 1500, 25, 3, 1, 'win'),
(2, 1, '2025-05-19 15:30:00', '2025-05-19 15:45:30', 1350, 25, 3, 2, 'win'),
(2, 1, '2025-05-19 11:00:00', '2025-05-19 11:15:15', 1200, 25, 2, NULL, 'win');

-- Player 2 Sessions (Level 2: 5 played, 5 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 5 wins (all completed)
(2, 2, '2025-05-22 08:15:00', '2025-05-22 08:40:30', 2000, 20, 3, NULL, 'win'),
(2, 2, '2025-05-21 14:30:00', '2025-05-21 14:55:20', 1950, 20, 3, 1, 'win'),
(2, 2, '2025-05-21 09:45:00', '2025-05-21 10:10:45', 1900, 20, 3, NULL, 'win'),
(2, 2, '2025-05-20 17:15:00', '2025-05-20 17:40:30', 1800, 20, 2, 2, 'win'),
(2, 2, '2025-05-20 12:30:00', '2025-05-20 12:55:15', 1700, 20, 2, NULL, 'win');

-- Player 2 Sessions (Level 3: 7 played, 6 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 6 wins (keeping highest scores)
(2, 3, '2025-05-24 17:15:00', '2025-05-24 17:45:30', 2500, 18, 2, NULL, 'win'),
(2, 3, '2025-05-23 13:30:00', '2025-05-23 14:00:20', 2400, 18, 2, 1, 'win'),
(2, 3, '2025-05-24 12:30:00', '2025-05-24 13:00:15', 2450, 18, 2, 3, 'win'),
(2, 3, '2025-05-23 09:45:00', '2025-05-23 10:15:45', 2300, 18, 2, NULL, 'win'),
(2, 3, '2025-05-22 16:15:00', '2025-05-22 16:45:30', 2200, 18, 2, 2, 'win'),
(2, 3, '2025-05-22 10:30:00', '2025-05-22 11:00:15', 2100, 18, 1, NULL, 'win'),
-- 1 loss
(2, 3, '2025-05-24 08:15:00', '2025-05-24 08:45:30', 2350, 18, 0, NULL, 'lose');

-- Player 2 Sessions (Level 4: 10 played, 8 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 8 wins (keeping highest scores)
(2, 4, '2025-05-27 19:15:00', '2025-05-27 19:50:30', 2800, 15, 2, 1, 'win'),
(2, 4, '2025-05-26 18:00:00', '2025-05-26 18:35:30', 2800, 15, 2, NULL, 'win'),
(2, 4, '2025-05-25 17:45:00', '2025-05-25 18:20:20', 2700, 15, 2, 1, 'win'),
(2, 4, '2025-05-26 09:30:00', '2025-05-26 10:05:30', 2750, 15, 2, NULL, 'win'),
(2, 4, '2025-05-27 15:30:00', '2025-05-27 16:05:20', 2750, 15, 2, NULL, 'win'),
(2, 4, '2025-05-24 19:30:00', '2025-05-24 20:05:15', 2600, 15, 1, NULL, 'win'),
(2, 4, '2025-05-25 10:45:00', '2025-05-25 11:20:30', 2650, 15, 1, 2, 'win'),
(2, 4, '2025-05-26 13:15:00', '2025-05-26 13:50:15', 2650, 15, 1, 3, 'win'),
-- 2 losses
(2, 4, '2025-05-25 14:30:00', '2025-05-25 15:05:45', 2550, 15, 0, NULL, 'lose'),
(2, 4, '2025-05-27 10:45:00', '2025-05-27 11:20:45', 2700, 15, 0, 2, 'lose');

-- Player 2 Sessions (Level 5: 15 played, 10 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 10 wins (keeping highest scores)
(2, 5, '2025-06-02 09:00:00', '2025-06-02 09:40:30', 3200, 12, 1, NULL, 'win'),
(2, 5, '2025-05-31 13:45:00', '2025-05-31 14:25:30', 3150, 12, 1, 1, 'win'),
(2, 5, '2025-05-30 15:15:00', '2025-05-30 15:55:45', 3200, 12, 1, 2, 'win'),
(2, 5, '2025-05-29 13:15:00', '2025-05-29 13:55:30', 3050, 12, 1, NULL, 'win'),
(2, 5, '2025-05-28 12:15:00', '2025-05-28 12:55:30', 2950, 12, 1, 2, 'win'),
(2, 5, '2025-05-30 10:45:00', '2025-05-30 11:25:30', 3150, 12, 1, NULL, 'win'),
(2, 5, '2025-05-29 17:30:00', '2025-05-29 18:10:15', 3100, 12, 1, 3, 'win'),
(2, 5, '2025-05-28 08:30:00', '2025-05-28 09:10:15', 2900, 12, 1, NULL, 'win'),
(2, 5, '2025-05-31 09:30:00', '2025-05-31 10:10:20', 3100, 12, 1, NULL, 'win'),
(2, 5, '2025-05-29 09:30:00', '2025-05-29 10:10:20', 3000, 12, 1, 1, 'win'),
-- 5 losses
(2, 5, '2025-05-28 16:45:00', '2025-05-28 17:25:45', 2850, 12, 0, NULL, 'lose'),
(2, 5, '2025-05-30 13:15:00', '2025-05-30 13:55:45', 3000, 12, 0, NULL, 'lose'),
(2, 5, '2025-05-31 17:45:00', '2025-05-31 18:25:20', 2950, 12, 0, NULL, 'lose'),
(2, 5, '2025-06-01 10:15:00', '2025-06-01 10:55:30', 3050, 12, 0, 3, 'lose'),
(2, 5, '2025-06-01 14:30:00', '2025-06-01 15:10:45', 3100, 12, 0, NULL, 'lose');

-- Player 3 Sessions (Level 1: 7 played, 5 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 5 wins (keeping highest scores)
(3, 1, '2025-05-24 09:30:00', '2025-05-24 09:45:30', 1100, 25, 2, NULL, 'win'),
(3, 1, '2025-05-22 10:45:00', '2025-05-22 11:00:45', 850, 25, 2, NULL, 'win'),
(3, 1, '2025-05-23 08:15:00', '2025-05-23 08:30:30', 950, 25, 2, NULL, 'win'),
(3, 1, '2025-05-21 14:15:00', '2025-05-21 14:30:30', 750, 25, 1, 2, 'win'),
(3, 1, '2025-05-21 09:30:00', '2025-05-21 09:45:15', 600, 25, 1, NULL, 'win'),
-- 2 losses
(3, 1, '2025-05-22 16:30:00', '2025-05-22 16:45:20', 700, 25, 0, 1, 'lose'),
(3, 1, '2025-05-23 12:45:00', '2025-05-23 13:00:15', 800, 25, 0, 3, 'lose');

-- Player 3 Sessions (Level 2: 10 played, 7 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 7 wins (keeping highest scores)
(3, 2, '2025-05-28 10:45:00', '2025-05-28 11:10:30', 1600, 20, 1, 1, 'win'),
(3, 2, '2025-05-27 16:30:00', '2025-05-27 16:55:20', 1500, 20, 1, NULL, 'win'),
(3, 2, '2025-05-26 13:45:00', '2025-05-26 14:10:15', 1500, 20, 1, 3, 'win'),
(3, 2, '2025-05-25 14:30:00', '2025-05-25 14:55:20', 1400, 20, 1, 1, 'win'),
(3, 2, '2025-05-24 11:15:00', '2025-05-24 11:40:15', 1200, 20, 1, NULL, 'win'),
(3, 2, '2025-05-24 15:30:00', '2025-05-24 15:55:30', 1300, 20, 1, 2, 'win'),
(3, 2, '2025-05-26 09:15:00', '2025-05-26 09:40:30', 1450, 20, 1, NULL, 'win'),
-- 3 losses
(3, 2, '2025-05-25 10:45:00', '2025-05-25 11:10:45', 1100, 20, 0, NULL, 'lose'),
(3, 2, '2025-05-27 08:30:00', '2025-05-27 08:55:30', 1400, 20, 0, NULL, 'lose'),
(3, 2, '2025-05-27 12:15:00', '2025-05-27 12:40:45', 1350, 20, 0, 2, 'lose');

-- Player 4 Sessions (Level 1: 10 played, 5 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 5 wins (keeping highest scores)
(4, 1, '2025-05-26 14:45:00', '2025-05-26 15:00:30', 800, 25, 1, 1, 'win'),
(4, 1, '2025-05-24 10:15:00', '2025-05-24 10:30:30', 650, 25, 1, NULL, 'win'),
(4, 1, '2025-05-23 09:45:00', '2025-05-23 10:00:45', 550, 25, 1, NULL, 'win'),
(4, 1, '2025-05-22 12:30:00', '2025-05-22 12:45:30', 500, 25, 1, 2, 'win'),
(4, 1, '2025-05-25 08:30:00', '2025-05-25 08:45:30', 750, 25, 1, NULL, 'win'),
-- 5 losses
(4, 1, '2025-05-22 08:15:00', '2025-05-22 08:30:15', 400, 25, 0, NULL, 'lose'),
(4, 1, '2025-05-23 14:30:00', '2025-05-23 14:45:20', 450, 25, 0, 1, 'lose'),
(4, 1, '2025-05-24 15:45:00', '2025-05-24 16:00:15', 600, 25, 0, 3, 'lose'),
(4, 1, '2025-05-25 13:15:00', '2025-05-25 13:30:45', 550, 25, 0, 2, 'lose'),
(4, 1, '2025-05-26 09:30:00', '2025-05-26 09:45:20', 700, 25, 0, NULL, 'lose');

-- Player 5 Sessions (Level 1: 4 played, 4 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 4 wins (all completed)
(5, 1, '2025-05-23 17:30:00', '2025-05-23 17:45:20', 1300, 25, 3, 1, 'win'),
(5, 1, '2025-05-22 11:45:00', '2025-05-22 12:00:45', 1200, 25, 3, NULL, 'win'),
(5, 1, '2025-05-21 15:15:00', '2025-05-21 15:30:30', 1100, 25, 3, 2, 'win'),
(5, 1, '2025-05-20 10:30:00', '2025-05-20 10:45:15', 900, 25, 2, NULL, 'win');

-- Player 5 Sessions (Level 2: 6 played, 6 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 6 wins (all completed)
(5, 2, '2025-05-27 08:45:00', '2025-05-27 09:10:15', 1900, 20, 2, 3, 'win'),
(5, 2, '2025-05-25 15:30:00', '2025-05-25 15:55:20', 1800, 20, 2, 1, 'win'),
(5, 2, '2025-05-25 09:45:00', '2025-05-25 10:10:45', 1700, 20, 2, NULL, 'win'),
(5, 2, '2025-05-24 13:30:00', '2025-05-24 13:55:30', 1600, 20, 2, 2, 'win'),
(5, 2, '2025-05-24 08:15:00', '2025-05-24 08:40:15', 1500, 20, 1, NULL, 'win'),
(5, 2, '2025-05-26 10:15:00', '2025-05-26 10:40:30', 1750, 20, 2, NULL, 'win');

-- Player 5 Sessions (Level 3: 8 played, 7 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 7 wins (keeping highest scores)
(5, 3, '2025-05-30 13:15:00', '2025-05-30 13:45:45', 2400, 18, 2, 2, 'win'),
(5, 3, '2025-05-28 16:30:00', '2025-05-28 17:00:20', 2200, 18, 2, 1, 'win'),
(5, 3, '2025-05-29 14:45:00', '2025-05-29 15:15:15', 2300, 18, 2, 3, 'win'),
(5, 3, '2025-05-27 17:15:00', '2025-05-27 17:45:30', 2100, 18, 1, 2, 'win'),
(5, 3, '2025-05-29 09:15:00', '2025-05-29 09:45:30', 2250, 18, 2, NULL, 'win'),
(5, 3, '2025-05-27 12:30:00', '2025-05-27 13:00:15', 2000, 18, 1, NULL, 'win'),
(5, 3, '2025-05-30 08:30:00', '2025-05-30 09:00:30', 2350, 18, 2, NULL, 'win'),
-- 1 loss
(5, 3, '2025-05-28 11:45:00', '2025-05-28 12:15:45', 1900, 18, 0, NULL, 'lose');

-- Player 5 Sessions (Level 4: 12 played, 9 completed)
INSERT INTO game_sessions (player_id, level_id, start_time, end_time, score, moves_used, stars_earned, item_used, result) VALUES
-- 9 wins (keeping highest scores)
(5, 4, '2025-06-05 09:30:00', '2025-06-05 10:05:30', 2750, 15, 1, 3, 'win'),
(5, 4, '2025-06-03 14:30:00', '2025-06-03 15:05:20', 2800, 15, 1, NULL, 'win'),
(5, 4, '2025-06-01 14:15:00', '2025-06-01 14:50:30', 2650, 15, 1, NULL, 'win'),
(5, 4, '2025-06-04 16:15:00', '2025-06-04 16:50:15', 2700, 15, 1, NULL, 'win'),
(5, 4, '2025-05-31 11:20:30', '2025-05-31 11:55:45', 2500, 15, 1, 2, 'win'),
(5, 4, '2025-06-01 10:20:20', '2025-06-01 10:55:30', 2600, 15, 1, 1, 'win'),
(5, 4, '2025-06-02 09:20:15', '2025-06-02 09:55:30', 2700, 15, 1, 3, 'win'),
(5, 4, '2025-06-03 09:50:45', '2025-06-03 10:25:15', 2750, 15, 1, 2, 'win'),
(5, 4, '2025-06-04 11:20:30', '2025-06-04 11:55:45', 2650, 15, 1, 1, 'win'),
-- 3 losses
(5, 4, '2025-05-30 17:30:00', '2025-05-30 18:05:15', 2400, 15, 0, NULL, 'lose'),
(5, 4, '2025-05-31 15:30:00', '2025-05-31 16:05:45', 2350, 15, 0, NULL, 'lose'),
(5, 4, '2025-06-02 12:30:00', '2025-06-02 13:05:30', 2550, 15, 0, NULL, 'lose');

-- Leaderboards Table
CREATE TABLE leaderboards (
    leaderboard_id INT PRIMARY KEY AUTO_INCREMENT,
    level_id INT,
    scope ENUM('global', 'weekly', 'daily', 'friends') NOT NULL,
    start_date DATETIME,
    end_date DATETIME,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (level_id) REFERENCES levels(level_id) ON DELETE CASCADE
);

-- Insert 5 leaderboards
INSERT INTO leaderboards (level_id, scope, start_date, end_date, is_active) VALUES
(1, 'global', '2025-05-01 00:00:00', '2025-05-31 23:59:59', TRUE),
(2, 'weekly', '2025-05-19 00:00:00', '2025-05-25 23:59:59', TRUE),
(3, 'daily', '2025-05-24 00:00:00', '2025-05-24 23:59:59', TRUE),
(4, 'friends', '2025-05-01 00:00:00', '2025-05-31 23:59:59', TRUE),
(5, 'global', '2025-05-01 00:00:00', '2025-05-31 23:59:59', TRUE);

-- Leaderboard Entries Table
CREATE TABLE leaderboard_entries (
    entry_id INT PRIMARY KEY AUTO_INCREMENT,
    leaderboard_id INT NOT NULL,
    player_id INT NOT NULL,
    score INT NOT NULL,
    rank INT,
    entry_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (leaderboard_id) REFERENCES leaderboards(leaderboard_id) ON DELETE CASCADE,
    FOREIGN KEY (player_id) REFERENCES players(player_id) ON DELETE CASCADE,
    UNIQUE (leaderboard_id, player_id)
);

-- Leaderboard 1 (Level 1 - Global) - All players have reached level 1
INSERT INTO leaderboard_entries (leaderboard_id, player_id, score, rank, entry_date) VALUES
(1, 1, 1200, 1, '2025-05-1 10:00:00'),
(1, 2, 1500, 2, '2025-05-1 10:00:00'),
(1, 3, 1100, 3, '2025-05-1 10:00:00'),
(1, 4, 800, 4, '2025-05-1 10:00:00'),
(1, 5, 1300, 5, '2025-05-1 10:00:00');

-- Leaderboard 2 (Level 2 - Weekly) - Players 1,2,3,5 have reached level 2
INSERT INTO leaderboard_entries (leaderboard_id, player_id, score, rank, entry_date) VALUES
(2, 1, 1800, 1, '2025-05-19 10:00:00'),
(2, 2, 2000, 2, '2025-05-19 10:00:00'),
(2, 3, 1600, 3, '2025-05-19 10:00:00'),
(2, 5, 1900, 4, '2025-05-19 10:00:00');

-- Leaderboard 3 (Level 3 - Daily) - Players 1,2,5 have reached level 3
INSERT INTO leaderboard_entries (leaderboard_id, player_id, score, rank, entry_date) VALUES
(3, 1, 2200, 1, '2025-05-24 10:00:00'),
(3, 2, 2500, 2, '2025-05-24 10:00:00'),
(3, 5, 2300, 3, '2025-05-24 10:00:00');

-- Leaderboard 4 (Level 4 - Friends) - Players 2,5 have reached level 4
INSERT INTO leaderboard_entries (leaderboard_id, player_id, score, rank, entry_date) VALUES
(4, 2, 2800, 1, '2025-05-1 10:00:00'),
(4, 5, 2700, 2, '2025-05-1 10:00:00');

-- Leaderboard 5 (Level 5 - Global) - Only player 2 has reached level 5
INSERT INTO leaderboard_entries (leaderboard_id, player_id, score, rank, entry_date) VALUES
(5, 2, 3200, 1, '2025-05-1 10:00:00');