-- Intelligence Hub Platform Database Schema
-- Generated: 2025-11-20 16:57:19
-- Platform: "LightSpeed Vend POS - Complete Ecosystem Edition"

SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================================
-- CORE PLATFORM TABLES
-- ============================================================================

-- Staff AI Bots
CREATE TABLE IF NOT EXISTS staff_ai_bots (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    staff_id BIGINT UNSIGNED NOT NULL UNIQUE,
    unit_id INT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    status ENUM('active', 'inactive', 'paused') DEFAULT 'active',
    personality_profile JSON,
    specializations JSON,
    learning_progress FLOAT DEFAULT 0,
    total_conversations BIGINT DEFAULT 0,
    total_tasks_completed BIGINT DEFAULT 0,
    avg_response_time_ms INT DEFAULT 0,
    customer_satisfaction_score FLOAT DEFAULT 0,
    last_active_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_staff_id (staff_id),
    INDEX idx_unit_id (unit_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bot Knowledge Base
CREATE TABLE IF NOT EXISTS staff_bot_knowledge (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    bot_id BIGINT UNSIGNED NOT NULL,
    document_id VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    content_type ENUM('text', 'pdf', 'image', 'json', 'database') DEFAULT 'text',
    embedding LONGBLOB,
    keywords JSON,
    entities JSON,
    source_url VARCHAR(500),
    relevance_score FLOAT DEFAULT 0,
    times_referenced INT DEFAULT 0,
    last_accessed_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FULLTEXT INDEX ft_content (content),
    INDEX idx_bot_id (bot_id),
    INDEX idx_relevance (relevance_score),
    FOREIGN KEY (bot_id) REFERENCES staff_ai_bots(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Conversations
CREATE TABLE IF NOT EXISTS conversations (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    bot_id BIGINT UNSIGNED NOT NULL,
    conversation_hash VARCHAR(64) UNIQUE,
    topic VARCHAR(255),
    intent VARCHAR(100),
    status ENUM('active', 'closed', 'archived') DEFAULT 'active',
    message_count INT DEFAULT 0,
    customer_satisfaction INT,
    resolution_time_seconds INT,
    feedback_provided BOOLEAN DEFAULT FALSE,
    metadata JSON,
    started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ended_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_bot_id (bot_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (bot_id) REFERENCES staff_ai_bots(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Messages in Conversations
CREATE TABLE IF NOT EXISTS messages (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    conversation_id BIGINT UNSIGNED NOT NULL,
    sender_type ENUM('user', 'bot', 'system') DEFAULT 'user',
    sender_id VARCHAR(255),
    message_text LONGTEXT NOT NULL,
    intent_detected VARCHAR(100),
    sentiment ENUM('positive', 'neutral', 'negative') DEFAULT 'neutral',
    confidence_score FLOAT DEFAULT 0,
    response_time_ms INT,
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_conversation_id (conversation_id),
    INDEX idx_sender_type (sender_type),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (conversation_id) REFERENCES conversations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bot Specializations
CREATE TABLE IF NOT EXISTS specializations (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    bot_id BIGINT UNSIGNED NOT NULL,
    specialization_name VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    proficiency_level ENUM('novice', 'intermediate', 'advanced', 'expert') DEFAULT 'novice',
    training_data_count INT DEFAULT 0,
    success_rate FLOAT DEFAULT 0,
    last_trained_at TIMESTAMP,
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_bot_id (bot_id),
    INDEX idx_category (category),
    FOREIGN KEY (bot_id) REFERENCES staff_ai_bots(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Learning Sessions
CREATE TABLE IF NOT EXISTS learning_sessions (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    bot_id BIGINT UNSIGNED NOT NULL,
    specialization_id BIGINT UNSIGNED,
    session_type ENUM('feedback_loop', 'manual_training', 'auto_learning') DEFAULT 'auto_learning',
    training_data JSON,
    feedback_provided JSON,
    improvement_metrics JSON,
    session_status ENUM('active', 'completed', 'failed') DEFAULT 'active',
    started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_bot_id (bot_id),
    FOREIGN KEY (bot_id) REFERENCES staff_ai_bots(id) ON DELETE CASCADE,
    FOREIGN KEY (specialization_id) REFERENCES specializations(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data Access Audit Trail
CREATE TABLE IF NOT EXISTS data_access (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    bot_id BIGINT UNSIGNED NOT NULL,
    resource_type VARCHAR(100),
    resource_id VARCHAR(255),
    action ENUM('read', 'write', 'update', 'delete') DEFAULT 'read',
    accessed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    user_agent VARCHAR(500),
    metadata JSON,
    INDEX idx_bot_id (bot_id),
    INDEX idx_accessed_at (accessed_at),
    FOREIGN KEY (bot_id) REFERENCES staff_ai_bots(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bot Tasks (Reminders, Reports, Workflows, etc.)
CREATE TABLE IF NOT EXISTS tasks (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    bot_id BIGINT UNSIGNED NOT NULL,
    task_type ENUM('reminder', 'report', 'workflow', 'sync', 'notification') DEFAULT 'reminder',
    title VARCHAR(500),
    description LONGTEXT,
    priority ENUM('low', 'medium', 'high', 'critical') DEFAULT 'medium',
    status ENUM('pending', 'in_progress', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
    scheduled_at TIMESTAMP,
    due_at TIMESTAMP,
    completed_at TIMESTAMP,
    result_data JSON,
    error_message TEXT,
    retry_count INT DEFAULT 0,
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_bot_id (bot_id),
    INDEX idx_task_type (task_type),
    INDEX idx_status (status),
    INDEX idx_scheduled_at (scheduled_at),
    FOREIGN KEY (bot_id) REFERENCES staff_ai_bots(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bot Integration Configuration
CREATE TABLE IF NOT EXISTS integrations (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    bot_id BIGINT UNSIGNED NOT NULL,
    service_name VARCHAR(255) NOT NULL,
    service_type ENUM('api', 'webhook', 'database', 'file_storage', 'ai_service') DEFAULT 'api',
    is_enabled BOOLEAN DEFAULT FALSE,
    config_encrypted LONGBLOB,
    last_sync_at TIMESTAMP,
    sync_status ENUM('success', 'failed', 'pending') DEFAULT 'pending',
    error_log TEXT,
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_bot_id (bot_id),
    INDEX idx_service_name (service_name),
    FOREIGN KEY (bot_id) REFERENCES staff_ai_bots(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Analytics
CREATE TABLE IF NOT EXISTS bot_analytics (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    bot_id BIGINT UNSIGNED NOT NULL,
    metric_name VARCHAR(255),
    metric_value FLOAT,
    metric_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    metadata JSON,
    INDEX idx_bot_id (bot_id),
    INDEX idx_metric_timestamp (metric_timestamp),
    FOREIGN KEY (bot_id) REFERENCES staff_ai_bots(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci PARTITION BY RANGE(YEAR(metric_timestamp)) (
    PARTITION p2024 VALUES LESS THAN (2025),
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION p_future VALUES LESS THAN MAXVALUE
);

-- ============================================================================
-- API INTEGRATION TABLES
-- ============================================================================

-- API Integrations
CREATE TABLE IF NOT EXISTS api_integrations (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    unit_id INT UNSIGNED NOT NULL,
    service_name VARCHAR(255) NOT NULL UNIQUE,
    service_type VARCHAR(100),
    base_url VARCHAR(500),
    description TEXT,
    is_enabled BOOLEAN DEFAULT FALSE,
    rate_limit_per_hour INT DEFAULT 1000,
    timeout_seconds INT DEFAULT 30,
    retry_attempts INT DEFAULT 3,
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_unit_id (unit_id),
    INDEX idx_service_name (service_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- API Credentials (encrypted)
CREATE TABLE IF NOT EXISTS api_credentials (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    integration_id BIGINT UNSIGNED NOT NULL,
    credential_type ENUM('api_key', 'oauth2', 'basic_auth', 'bearer_token', 'jwt') DEFAULT 'api_key',
    credential_key VARCHAR(255),
    credential_value_encrypted LONGBLOB,
    oauth_refresh_token_encrypted LONGBLOB,
    oauth_expires_at TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE,
    last_validated_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_integration_id (integration_id),
    FOREIGN KEY (integration_id) REFERENCES api_integrations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- API Endpoints
CREATE TABLE IF NOT EXISTS api_endpoints (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    integration_id BIGINT UNSIGNED NOT NULL,
    endpoint_name VARCHAR(255),
    endpoint_path VARCHAR(500),
    http_method ENUM('GET', 'POST', 'PUT', 'PATCH', 'DELETE') DEFAULT 'GET',
    description TEXT,
    parameters JSON,
    response_format VARCHAR(50),
    rate_limit INT,
    is_paginated BOOLEAN DEFAULT FALSE,
    pagination_key VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_integration_id (integration_id),
    FOREIGN KEY (integration_id) REFERENCES api_integrations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- API Requests (quarterly partitioned)
CREATE TABLE IF NOT EXISTS api_requests (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    integration_id BIGINT UNSIGNED NOT NULL,
    endpoint_id BIGINT UNSIGNED,
    request_method VARCHAR(10),
    request_path VARCHAR(500),
    request_headers JSON,
    request_body LONGTEXT,
    response_status INT,
    response_body LONGTEXT,
    response_time_ms INT,
    error_message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_integration_id (integration_id),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (integration_id) REFERENCES api_integrations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
PARTITION BY RANGE(QUARTER(created_at)) (
    PARTITION q1 VALUES LESS THAN (2),
    PARTITION q2 VALUES LESS THAN (3),
    PARTITION q3 VALUES LESS THAN (4),
    PARTITION q4 VALUES LESS THAN (5)
);

-- Webhooks
CREATE TABLE IF NOT EXISTS api_webhooks (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    integration_id BIGINT UNSIGNED NOT NULL,
    webhook_url VARCHAR(500),
    event_type VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    signature_secret_encrypted LONGBLOB,
    last_triggered_at TIMESTAMP,
    trigger_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_integration_id (integration_id),
    FOREIGN KEY (integration_id) REFERENCES api_integrations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Webhook Events (monthly partitioned)
CREATE TABLE IF NOT EXISTS api_webhook_events (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    webhook_id BIGINT UNSIGNED NOT NULL,
    event_id VARCHAR(255) UNIQUE,
    event_type VARCHAR(255),
    payload JSON,
    delivery_status ENUM('pending', 'sent', 'failed', 'retrying') DEFAULT 'pending',
    delivery_attempts INT DEFAULT 0,
    last_delivery_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_webhook_id (webhook_id),
    INDEX idx_event_id (event_id),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (webhook_id) REFERENCES api_webhooks(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
PARTITION BY RANGE(MONTH(created_at)) (
    PARTITION m1 VALUES LESS THAN (2),
    PARTITION m2 VALUES LESS THAN (3),
    PARTITION m3 VALUES LESS THAN (4),
    PARTITION m4 VALUES LESS THAN (5),
    PARTITION m5 VALUES LESS THAN (6),
    PARTITION m6 VALUES LESS THAN (7),
    PARTITION m7 VALUES LESS THAN (8),
    PARTITION m8 VALUES LESS THAN (9),
    PARTITION m9 VALUES LESS THAN (10),
    PARTITION m10 VALUES LESS THAN (11),
    PARTITION m11 VALUES LESS THAN (12),
    PARTITION m12 VALUES LESS THAN (13)
);

-- Sync Jobs
CREATE TABLE IF NOT EXISTS api_sync_jobs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    integration_id BIGINT UNSIGNED NOT NULL,
    sync_type ENUM('pull', 'push', 'bidirectional') DEFAULT 'pull',
    resource_type VARCHAR(255),
    schedule_cron VARCHAR(255),
    is_enabled BOOLEAN DEFAULT TRUE,
    last_run_at TIMESTAMP,
    next_run_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_integration_id (integration_id),
    FOREIGN KEY (integration_id) REFERENCES api_integrations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sync Runs (monthly partitioned)
CREATE TABLE IF NOT EXISTS api_sync_runs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    sync_job_id BIGINT UNSIGNED NOT NULL,
    run_status ENUM('pending', 'running', 'completed', 'failed', 'partial') DEFAULT 'pending',
    records_fetched INT DEFAULT 0,
    records_synced INT DEFAULT 0,
    records_failed INT DEFAULT 0,
    sync_duration_seconds INT,
    error_log TEXT,
    started_at TIMESTAMP,
    completed_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_sync_job_id (sync_job_id),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (sync_job_id) REFERENCES api_sync_jobs(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
PARTITION BY RANGE(MONTH(created_at)) (
    PARTITION m1 VALUES LESS THAN (2),
    PARTITION m2 VALUES LESS THAN (3),
    PARTITION m3 VALUES LESS THAN (4),
    PARTITION m4 VALUES LESS THAN (5),
    PARTITION m5 VALUES LESS THAN (6),
    PARTITION m6 VALUES LESS THAN (7),
    PARTITION m7 VALUES LESS THAN (8),
    PARTITION m8 VALUES LESS THAN (9),
    PARTITION m9 VALUES LESS THAN (10),
    PARTITION m10 VALUES LESS THAN (11),
    PARTITION m11 VALUES LESS THAN (12),
    PARTITION m12 VALUES LESS THAN (13)
);

-- Rate Limits
CREATE TABLE IF NOT EXISTS api_rate_limits (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    integration_id BIGINT UNSIGNED NOT NULL,
    window_start TIMESTAMP,
    request_count INT DEFAULT 0,
    limit_threshold INT,
    INDEX idx_integration_id (integration_id),
    FOREIGN KEY (integration_id) REFERENCES api_integrations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data Mappings
CREATE TABLE IF NOT EXISTS api_data_mappings (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    integration_id BIGINT UNSIGNED NOT NULL,
    source_table VARCHAR(255),
    target_table VARCHAR(255),
    field_mappings JSON,
    transformation_rules JSON,
    conflict_resolution VARCHAR(100),
    is_bidirectional BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_integration_id (integration_id),
    FOREIGN KEY (integration_id) REFERENCES api_integrations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- FEDERATION TABLES
-- ============================================================================

-- Satellites Registry
CREATE TABLE IF NOT EXISTS hub_satellites (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    unit_id INT UNSIGNED UNIQUE,
    satellite_name VARCHAR(255) NOT NULL,
    satellite_slug VARCHAR(255) UNIQUE,
    api_base_url VARCHAR(500),
    auth_token_encrypted LONGBLOB,
    health_status ENUM('healthy', 'degraded', 'unhealthy', 'offline') DEFAULT 'offline',
    health_check_status_code INT,
    health_check_response_time_ms INT,
    circuit_breaker_state ENUM('closed', 'open', 'half_open') DEFAULT 'closed',
    circuit_breaker_failure_count INT DEFAULT 0,
    circuit_breaker_last_failure TIMESTAMP,
    database_name VARCHAR(255),
    database_host VARCHAR(255),
    sync_enabled BOOLEAN DEFAULT TRUE,
    last_sync_at TIMESTAMP,
    last_sync_direction ENUM('pull', 'push', 'bidirectional') DEFAULT 'pull',
    data_version VARCHAR(100),
    deployment_version VARCHAR(100),
    deployed_at TIMESTAMP,
    deployment_status ENUM('pending', 'deploying', 'success', 'failed') DEFAULT 'pending',
    satellite_metadata JSON,
    priority INT DEFAULT 50,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_unit_id (unit_id),
    INDEX idx_health_status (health_status),
    INDEX idx_circuit_breaker_state (circuit_breaker_state)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Database Mappings
CREATE TABLE IF NOT EXISTS hub_database_mappings (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    satellite_id BIGINT UNSIGNED NOT NULL,
    source_table VARCHAR(255),
    target_table VARCHAR(255),
    sync_direction ENUM('pull', 'push', 'bidirectional') DEFAULT 'pull',
    sync_strategy VARCHAR(100),
    field_mappings JSON,
    conflict_resolution VARCHAR(100),
    change_detection_strategy VARCHAR(100),
    batch_size INT DEFAULT 100,
    parallel_transfer BOOLEAN DEFAULT FALSE,
    is_enabled BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_satellite_id (satellite_id),
    FOREIGN KEY (satellite_id) REFERENCES hub_satellites(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Federation Events (monthly partitioned)
CREATE TABLE IF NOT EXISTS hub_federation_events (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    satellite_id BIGINT UNSIGNED,
    event_type VARCHAR(100),
    event_category VARCHAR(50),
    severity ENUM('info', 'warning', 'error', 'critical') DEFAULT 'info',
    user_id BIGINT UNSIGNED,
    username VARCHAR(255),
    ip_address VARCHAR(45),
    user_agent VARCHAR(500),
    event_data JSON,
    recovery_action VARCHAR(255),
    recovery_status VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_satellite_id (satellite_id),
    INDEX idx_event_type (event_type),
    INDEX idx_severity (severity),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (satellite_id) REFERENCES hub_satellites(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
PARTITION BY RANGE(MONTH(created_at)) (
    PARTITION m1 VALUES LESS THAN (2),
    PARTITION m2 VALUES LESS THAN (3),
    PARTITION m3 VALUES LESS THAN (4),
    PARTITION m4 VALUES LESS THAN (5),
    PARTITION m5 VALUES LESS THAN (6),
    PARTITION m6 VALUES LESS THAN (7),
    PARTITION m7 VALUES LESS THAN (8),
    PARTITION m8 VALUES LESS THAN (9),
    PARTITION m9 VALUES LESS THAN (10),
    PARTITION m10 VALUES LESS THAN (11),
    PARTITION m11 VALUES LESS THAN (12),
    PARTITION m12 VALUES LESS THAN (13)
);

SET FOREIGN_KEY_CHECKS = 1;