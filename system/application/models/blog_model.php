<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog_model extends Model {

    function Blog_model() {
        parent::Model();
    }
    
    function all_blog_content($type="data",$cat = "",$num = 10, $offset = 0) {
        
        if("" != $cat){
            if("data" == $type){
                $sql = "SELECT p.ID,p.post_name,p.post_title,p.post_content,DATE(p.post_date) date,GROUP_CONCAT(t.name) category
                            FROM blog_wp_posts p
                            LEFT JOIN blog_wp_term_relationships rel ON rel.object_id = p.ID
                            LEFT JOIN blog_wp_term_taxonomy tax ON (tax.term_taxonomy_id = rel.term_taxonomy_id AND tax.taxonomy='category')
                            LEFT JOIN blog_wp_terms t ON (t.term_id = tax.term_id AND t.name!='uncategorized')
                            WHERE p.post_status = 'publish' AND t.name = '".$cat."' 
                            GROUP BY p.ID
                            ORDER BY date DESC
                            LIMIT ".$num." OFFSET ".intVal($offset);
                            //WHERE  AND (p.post_type='post' OR p.post_type='revision')

                $query  = $this->db->query($sql,false);
                if($query->num_rows() > 0){
                    return $query->result();
                }
            }else{
                $sql = "SELECT p.ID,p.post_title,p.post_content,DATE(p.post_date) date,GROUP_CONCAT(t.name) category
                            FROM blog_wp_posts p
                            LEFT JOIN blog_wp_term_relationships rel ON rel.object_id = p.ID
                            LEFT JOIN blog_wp_term_taxonomy tax ON (tax.term_taxonomy_id = rel.term_taxonomy_id AND tax.taxonomy='category')
                            LEFT JOIN blog_wp_terms t ON (t.term_id = tax.term_id AND t.name!='uncategorized')
                            WHERE p.post_status = 'publish'  AND t.name = '".$cat."' 
                            GROUP BY p.ID
                            ORDER BY date DESC";
                            //WHERE  AND (p.post_type='post' OR p.post_type='revision')

                $query  = $this->db->query($sql,false);
                return $query->num_rows();
            }
        }else{
            if("data" == $type){
                $sql = "SELECT p.ID,p.post_name,p.post_title,p.post_content,DATE(p.post_date) date,GROUP_CONCAT(t.name) category
                            FROM blog_wp_posts p
                            LEFT JOIN blog_wp_term_relationships rel ON rel.object_id = p.ID
                            LEFT JOIN blog_wp_term_taxonomy tax ON (tax.term_taxonomy_id = rel.term_taxonomy_id AND tax.taxonomy='category')
                            LEFT JOIN blog_wp_terms t ON (t.term_id = tax.term_id AND t.name!='uncategorized')
                            WHERE p.post_status = 'publish' 
                            GROUP BY p.ID
                            ORDER BY date DESC
                            LIMIT ".$num." OFFSET ".intVal($offset);
                            //WHERE  AND (p.post_type='post' OR p.post_type='revision')

                $query  = $this->db->query($sql,false);
                if($query->num_rows() > 0){
                    return $query->result();
                }
            }else{
                $sql = "SELECT p.ID,p.post_title,p.post_content,DATE(p.post_date) date,GROUP_CONCAT(t.name) category
                            FROM blog_wp_posts p
                            LEFT JOIN blog_wp_term_relationships rel ON rel.object_id = p.ID
                            LEFT JOIN blog_wp_term_taxonomy tax ON (tax.term_taxonomy_id = rel.term_taxonomy_id AND tax.taxonomy='category')
                            LEFT JOIN blog_wp_terms t ON (t.term_id = tax.term_id AND t.name!='uncategorized')
                            WHERE p.post_status = 'publish' 
                            GROUP BY p.ID
                            ORDER BY date DESC";
                            //WHERE  AND (p.post_type='post' OR p.post_type='revision')

                $query  = $this->db->query($sql,false);
                return $query->num_rows();
            }
        }
    }

    function blog_content($blog_name) {
        if ("" != $blog_name) {
            $sql = "SELECT p.ID,p.post_title,p.post_content,DATE(p.post_date) date,GROUP_CONCAT(t.name) category
                        FROM blog_wp_posts p
                        LEFT JOIN blog_wp_term_relationships rel ON rel.object_id = p.ID
                        LEFT JOIN blog_wp_term_taxonomy tax ON (tax.term_taxonomy_id = rel.term_taxonomy_id AND tax.taxonomy='category')
                        LEFT JOIN blog_wp_terms t ON (t.term_id = tax.term_id AND t.name!='uncategorized')
                        WHERE p.post_name = '".$blog_name."' AND p.post_status = 'publish' 
                        GROUP BY p.ID
                        ORDER BY date DESC";
                        //WHERE  AND (p.post_type='post' OR p.post_type='revision')
            
            $query  = $this->db->query($sql,false);
            if($query->num_rows() > 0){
                return $query->row();
            }
        }
    }
    
    function blog_meta($post_id){
        if ("" != $post_id) {
            $query = $this->db->select('meta_key, meta_value')
                    ->from('blog_wp_postmeta')
                    ->where('post_id', $post_id)
                    ->get();
            
            if($query->num_rows() > 0){
                return $query->result();
            }
        }
    }
    
    function get_recent_blog_content($not_id = ''){
        
        if("" != $not_id && 0 != $not_id){
            $sql = "SELECT p.ID,p.post_title,p.post_content,p.post_name,DATE(p.post_date) date,GROUP_CONCAT(t.name) category
                        FROM blog_wp_posts p
                        LEFT JOIN blog_wp_term_relationships rel ON rel.object_id = p.ID
                        LEFT JOIN blog_wp_term_taxonomy tax ON (tax.term_taxonomy_id = rel.term_taxonomy_id AND tax.taxonomy='category')
                        LEFT JOIN blog_wp_terms t ON (t.term_id = tax.term_id AND t.name!='uncategorized')
                        WHERE p.ID != ".$not_id." AND p.post_status = 'publish' AND p.post_type='post' 
                        GROUP BY p.post_name
                        ORDER BY date DESC LIMIT 5";

            $query  = $this->db->query($sql,false);
            if($query->num_rows() > 0){
                return $query->result();
            }
        }else{
            $sql = "SELECT p.ID,p.post_title,p.post_content,p.post_name,DATE(p.post_date) date,GROUP_CONCAT(t.name) category
                        FROM blog_wp_posts p
                        LEFT JOIN blog_wp_term_relationships rel ON rel.object_id = p.ID
                        LEFT JOIN blog_wp_term_taxonomy tax ON (tax.term_taxonomy_id = rel.term_taxonomy_id AND tax.taxonomy='category')
                        LEFT JOIN blog_wp_terms t ON (t.term_id = tax.term_id AND t.name!='uncategorized')
                        WHERE p.post_status = 'publish' AND p.post_type='post' 
                        GROUP BY p.post_name
                        ORDER BY date DESC LIMIT 5";

            $query  = $this->db->query($sql,false);
            if($query->num_rows() > 0){
                return $query->result();
            }
        }
    }
    
    function get_related_blog($category, $not_id = ''){
        if("" != $category && "" != $not_id){
            $sql = "SELECT p.ID,p.post_title,p.post_content,p.post_name,DATE(p.post_date) date,GROUP_CONCAT(t.name) category
                        FROM blog_wp_posts p
                        LEFT JOIN blog_wp_term_relationships rel ON rel.object_id = p.ID
                        LEFT JOIN blog_wp_term_taxonomy tax ON (tax.term_taxonomy_id = rel.term_taxonomy_id AND tax.taxonomy='category')
                        LEFT JOIN blog_wp_terms t ON (t.term_id = tax.term_id AND t.name!='uncategorized')
                        WHERE p.ID != ".$not_id." AND t.name = '".$category."' AND p.post_status = 'publish' AND p.post_type='post' 
                        GROUP BY p.post_name
                        ORDER BY date DESC LIMIT 3";

            $query  = $this->db->query($sql,false);
            if($query->num_rows() > 0){
                return $query->result();
            }
        }
    }

}
