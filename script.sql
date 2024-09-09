DO $$
DECLARE
    v_table_name TEXT;
    v_constraint_name TEXT;
    v_column_type TEXT;
    v_max_id BIGINT;
    v_fk_record RECORD;
    v_fk_drop_commands TEXT := '';
    v_fk_recreate_commands TEXT := '';
BEGIN
    -- Start a transaction
    BEGIN
        FOR v_table_name IN
            SELECT table_name
            FROM information_schema.columns
            WHERE column_name = 'id'
              AND table_schema = 'public'
        LOOP
            RAISE NOTICE 'Processing table: %', v_table_name;
            
            -- Check current data type of 'id' column
            SELECT data_type INTO v_column_type
            FROM information_schema.columns
            WHERE table_name = v_table_name
              AND column_name = 'id'
              AND table_schema = 'public';
            
            IF v_column_type = 'integer' THEN
                RAISE NOTICE 'Table % already has INTEGER id. Skipping.', v_table_name;
                CONTINUE;
            END IF;
            
            -- Identify foreign key constraints referencing this table
            FOR v_fk_record IN 
                SELECT
                    tc.table_schema AS schema_name,
                    tc.table_name,
                    kcu.column_name,
                    ccu.table_name AS foreign_table_name,
                    ccu.column_name AS foreign_column_name,
                    tc.constraint_name
                FROM information_schema.table_constraints AS tc
                JOIN information_schema.key_column_usage AS kcu ON tc.constraint_name = kcu.constraint_name
                JOIN information_schema.constraint_column_usage AS ccu ON ccu.constraint_name = tc.constraint_name
                WHERE tc.constraint_type = 'FOREIGN KEY'
                  AND ccu.table_name = v_table_name
                  AND ccu.column_name = 'id'
            LOOP
                -- Store drop and recreate commands
                v_fk_drop_commands := v_fk_drop_commands || format('ALTER TABLE %I.%I DROP CONSTRAINT %I;',
                                      v_fk_record.schema_name, v_fk_record.table_name, v_fk_record.constraint_name);
                v_fk_recreate_commands := v_fk_recreate_commands || format('ALTER TABLE %I.%I ADD CONSTRAINT %I FOREIGN KEY (%I) REFERENCES %I(id);',
                                          v_fk_record.schema_name, v_fk_record.table_name, v_fk_record.constraint_name,
                                          v_fk_record.column_name, v_table_name);
            END LOOP;

            -- Execute drop commands for foreign key constraints
            IF v_fk_drop_commands <> '' THEN
                EXECUTE v_fk_drop_commands;
                RAISE NOTICE 'Dropped foreign key constraints referencing table %', v_table_name;
            END IF;

            -- Drop existing primary key constraint
            SELECT constraint_name INTO v_constraint_name
            FROM information_schema.table_constraints
            WHERE table_name = v_table_name
              AND table_schema = 'public'
              AND constraint_type = 'PRIMARY KEY';
            
            IF v_constraint_name IS NOT NULL THEN
                EXECUTE format('ALTER TABLE %I DROP CONSTRAINT %I', v_table_name, v_constraint_name);
                RAISE NOTICE 'Dropped primary key constraint % on table %', v_constraint_name, v_table_name;
            END IF;
            
            -- Change column type to INTEGER
            BEGIN
                EXECUTE format('ALTER TABLE %I ALTER COLUMN id TYPE INTEGER USING id::INTEGER', v_table_name);
                RAISE NOTICE 'Changed id column type to INTEGER for table %', v_table_name;
            EXCEPTION
                WHEN others THEN
                    RAISE EXCEPTION 'Error converting id to INTEGER for table %: %', v_table_name, SQLERRM;
            END;
            
            -- Create a new sequence
            EXECUTE format('CREATE SEQUENCE IF NOT EXISTS %I_id_seq', v_table_name);
            RAISE NOTICE 'Created sequence %_id_seq', v_table_name;
            
            -- Set default value for the column
            EXECUTE format('ALTER TABLE %I ALTER COLUMN id SET DEFAULT nextval(''%I_id_seq'')', v_table_name, v_table_name);
            RAISE NOTICE 'Set default value for id column in table %', v_table_name;
            
            -- Reset the sequence to start from the maximum id or 1 if the table is empty
            EXECUTE format('SELECT COALESCE(MAX(id), 0) FROM %I', v_table_name) INTO v_max_id;
            IF v_max_id = 0 THEN
                v_max_id := 1;
            END IF;
            EXECUTE format('SELECT setval(''%I_id_seq'', $1, false)', v_table_name) USING v_max_id;
            RAISE NOTICE 'Reset sequence for table % to start from %', v_table_name, v_max_id;
            
            -- Recreate primary key constraint
            EXECUTE format('ALTER TABLE %I ADD PRIMARY KEY (id)', v_table_name);
            RAISE NOTICE 'Recreated primary key constraint on id for table %', v_table_name;

            -- Recreate foreign key constraints
            IF v_fk_recreate_commands <> '' THEN
                EXECUTE v_fk_recreate_commands;
                RAISE NOTICE 'Recreated foreign key constraints referencing table %', v_table_name;
            END IF;

            -- Reset the commands for the next iteration
            v_fk_drop_commands := '';
            v_fk_recreate_commands := '';
        END LOOP;
        
        RAISE NOTICE 'All tables processed successfully';
    EXCEPTION
        WHEN others THEN
            RAISE EXCEPTION 'An error occurred during processing: % (Table: %)', SQLERRM, v_table_name;
    END;
END $$;
