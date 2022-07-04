<?php


namespace Jobsys\MicroServices;


use Exception;

/**
 * API入参静态检查类
 * 可以对API的参数类型、长度、最大值等进行校验
 *
 **/
class RequestCheckUtil
{
    /**
     * 校验字段 fieldName 的值$value非空
     *
     *
     * @throws Exception
     */
    public static function checkNotNull($value, $field_name)
    {

        if (self::checkEmpty($value)) {
            throw new Exception("client-check-error:Missing Required Arguments: " . $field_name, 40);
        }
    }

    /**
     * 检验字段fieldName的值value 的长度
     *
     *
     * @throws Exception
     */
    public static function checkMaxLength($value, $max_length, $field_name)
    {
        if (!self::checkEmpty($value) && mb_strlen($value, "UTF-8") > $max_length) {
            throw new Exception("client-check-error:Invalid Arguments:the length of " . $field_name . " can not be larger than " . $max_length . ".", 41);
        }
    }

    /**
     * 检验字段fieldName的值value的最大列表长度
     *
     *
     * @throws Exception
     */
    public static function checkMaxListSize($value, $max_size, $field_name)
    {

        if (self::checkEmpty($value))
            return;

        $list = preg_split("/,/", $value);
        if (count($list) > $max_size) {
            throw new Exception("client-check-error:Invalid Arguments:the listsize(the string split by \",\") of " . $field_name . " must be less than " . $max_size . " .", 41);
        }
    }

    /**
     * 检验字段fieldName的值value 的最大值
     *
     *
     * @throws Exception
     */
    public static function checkMaxValue($value, $maxValue, $field_name)
    {

        if (self::checkEmpty($value))
            return;

        self::checkNumeric($value, $field_name);

        if ($value > $maxValue) {
            throw new Exception("client-check-error:Invalid Arguments:the value of " . $field_name . " can not be larger than " . $maxValue . " .", 41);
        }
    }

    /**
     * 检验字段fieldName的值value 的最小值
     *
     *
     * @throws Exception
     */
    public static function checkMinValue($value, $min_value, $field_name)
    {

        if (self::checkEmpty($value))
            return;

        self::checkNumeric($value, $field_name);

        if ($value < $min_value) {
            throw new Exception("client-check-error:Invalid Arguments:the value of " . $field_name . " can not be less than " . $min_value . " .", 41);
        }
    }

    /**
     * 检验字段fieldName的值value是否是number
     *
     *
     * @throws Exception
     */
    protected static function checkNumeric($value, $field_name)
    {
        if (!is_numeric($value))
            throw new Exception("client-check-error:Invalid Arguments:the value of " . $field_name . " is not number : " . $value . " .", 41);
    }

    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *  if is null , return true;
     **/
    public static function checkEmpty($value)
    {
        if (!isset($value))
            return true;
        if (is_array($value) && count($value) == 0)
            return true;
        if (is_string($value) && trim($value) === "")
            return true;

        return false;
    }

}