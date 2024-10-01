WITH active_offers AS
  (SELECT id,
          type,
          discount,
          price_type,
          start_time as start_date,
          end_time as end_date,
          category_id, (start_time IS NULL
                        OR start_time <= CURRENT_DATE)
                      AND (end_time IS NULL
                        OR end_time >= CURRENT_DATE) AS is_active
   FROM main_featuredoffer),
     products AS
  (SELECT p.id, 
          p.title,
          p.description,
          p.is_deleted,
          p.brand,
          p.status,
          p.price,
          p.discount_price,
          pc.id AS category_id,
          pc.label AS category_name,
          ao.type,
          ao.id AS offer_id,
          ao.discount,
          ao.price_type,
          ao.start_date,
          ao.end_date,
          ao.is_active,
          CASE
              WHEN ao.is_active THEN CASE
                                         WHEN ao.price_type = 'percentage' THEN p.price * (1 - CAST(ao.discount as numeric) / 100)
                                         WHEN ao.price_type = 'amount' THEN p.price - CAST(ao.discount as numeric)
                                         WHEN ao.price_type = 'fixed' THEN CAST(ao.discount as numeric)
                                         ELSE p.price
                                     END
              ELSE CASE
                       WHEN p.discount_price IS NOT NULL THEN p.discount_price
                       ELSE p.price
                   END
          END AS effective_price,
          CASE
            WHEN ao.is_active THEN CASE
                                        WHEN ao.price_type = 'percentage' THEN CAST(ao.discount as numeric)
                                        WHEN ao.price_type = 'amount' THEN (CAST(ao.discount as numeric) / p.price) * 100
                                        WHEN ao.price_type = 'fixed' THEN ((p.price - CAST(ao.discount as numeric)) / p.price) * 100
                                    END
            ELSE CASE
                  WHEN p.discount_price IS NOT NULL THEN ((p.price - p.discount_price) / p.price) * 100
                  ELSE 0
                END
          END as sale_percentage,
          json_agg(json_build_object(
              'language_code', pt.language_code,
              'title', pt.title,
              'description', pt.description
          )) FILTER (WHERE pt.title IS NOT NULL) as translations,

          json_agg(json_build_object(
              'name', ct.name,
              'language_code', ct.language_code,
              'image', ct.image
          )) FILTER (WHERE ct.name IS NOT NULL) AS category_translations,

          json_agg(json_build_object(
              'id', pi.id,
              'image', pi.image,
              'alt', pi.alt
          )) FILTER (WHERE pi.image IS NOT NULL) as images,

          json_build_object(
              'id', pc.id,
              'label', pc.label
          ) AS category



   FROM main_product p
   LEFT JOIN main_featuredoffer_main_products po ON p.id = po.product_id
   LEFT JOIN active_offers ao ON po.featured_offer_id = ao.id
   LEFT JOIN main_producttranslation pt ON pt.product_id = p.id
   LEFT JOIN main_category c ON ao.category_id = c.id
   LEFT JOIN main_category pc ON p.category_id = pc.id
   LEFT JOIN main_product_images pir ON p.id = pir.product_id
   LEFT JOIN main_image pi ON pir.image_id = pi.id
   LEFT JOIN categorytranslation ct ON p.category_id = ct.id
   WHERE ao.category_id IS NOT NULL AND p.is_deleted = FALSE AND p.status IN ('published', 'out_of_stock')
   GROUP BY p.id, p.title, p.is_deleted, p.status, p.price, p.discount_price, pc.id, pc.label, ao.type, ao.id, ao.discount, ao.price_type, ao.start_date, ao.end_date, ao.is_active
   UNION ALL SELECT p.id,
                    p.title,
                    p.description,
                    p.is_deleted,
                    p.brand,
                    p.status,
                    p.price,
                    p.discount_price,
                    pc.id AS category_id,
                    pc.label AS category_name,
                    ao.type,
                    ao.id AS offer_id,
                    ao.discount,
                    ao.price_type,
                    ao.start_date,
                    ao.end_date,
                    ao.is_active,
                    CASE
              WHEN ao.is_active THEN CASE
                                         WHEN ao.price_type = 'percentage' THEN p.price * (1 - CAST(ao.discount as numeric) / 100)
                                         WHEN ao.price_type = 'amount' THEN p.price - CAST(ao.discount as numeric)
                                         WHEN ao.price_type = 'fixed' THEN CAST(ao.discount as numeric)
                                         ELSE p.price
                                     END
              ELSE CASE
                       WHEN p.discount_price IS NOT NULL THEN p.discount_price
                       ELSE p.price
                   END
          END AS effective_price,
          CASE
            WHEN ao.is_active THEN CASE
                                        WHEN ao.price_type = 'percentage' THEN CAST(ao.discount as numeric)
                                        WHEN ao.price_type = 'amount' THEN (CAST(ao.discount as numeric) / p.price) * 100
                                        WHEN ao.price_type = 'fixed' THEN ((p.price - CAST(ao.discount as numeric)) / p.price) * 100
                                    END
            ELSE CASE
                  WHEN p.discount_price IS NOT NULL THEN ((p.price - p.discount_price) / p.price) * 100
                  ELSE 0
                END
          END as sale_percentage,
          json_agg(json_build_object(
              'language_code', pt.language_code,
              'title', pt.title,
              'description', pt.description
          )) FILTER (WHERE pt.title IS NOT NULL) AS translations,

          json_agg(json_build_object(
              'name', ct.name,
              'language_code', ct.language_code,
              'image', ct.image
          )) FILTER (WHERE ct.name IS NOT NULL) AS category_translations,

          json_agg(json_build_object(
              'id', pi.id,
              'image', pi.image,
              'alt', pi.alt
          )) FILTER (WHERE pi.image IS NOT NULL) as images,
          
          json_build_object(
              'id', pc.id,
              'label', pc.label
          ) AS category



   FROM main_product p
   LEFT JOIN main_featuredoffer_main_products po ON p.id = po.product_id
   LEFT JOIN active_offers ao ON po.featured_offer_id = ao.id
   LEFT JOIN main_producttranslation pt ON pt.product_id = p.id
   LEFT JOIN main_category c ON ao.category_id = c.id
   LEFT JOIN main_category pc ON p.category_id = pc.id
   LEFT JOIN main_product_images pir ON p.id = pir.product_id
   LEFT JOIN main_image pi ON pir.image_id = pi.id
   LEFT JOIN categorytranslation ct ON p.category_id = ct.id
   WHERE ao.category_id IS NULL AND p.is_deleted = false AND p.status IN ('published', 'out_of_stock')
   GROUP BY p.id, p.title, p.is_deleted, p.status, p.price, p.discount_price, pc.id, pc.label, ao.type, ao.id, ao.discount, ao.price_type, ao.start_date, ao.end_date, ao.is_active
) 
SELECT * FROM products
{{extra_sql}}
ORDER BY effective_price {{order_direction}};
