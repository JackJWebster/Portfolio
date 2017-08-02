#pragma once
#ifndef VECTOR_H
#define VECTOR_H

#ifndef M_PI
#define M_PI 3.14159265358979323846
#endif

#include <math.h>
#include <stdio.h>
#include <GLM/glm.hpp>

namespace jv {
	class vec3 {
	public:
		float x, y, z;
		vec3() { x = y = z = 0;};
		vec3(float a, float b, float c) {
			x = a;
			y = b;
			z = c;
		}

		void set(const float &a, const float &b, const float &c)
		{
			x = a;
			y = b;
			z = c;
		}

		bool operator==(vec3 rhs);
		vec3 operator+(vec3 rhs);
		vec3 operator+=(vec3 rhs);
		vec3 operator-(vec3 rhs);
		vec3 operator*(vec3 rhs);
		vec3 operator/(vec3 rhs);
		vec3 operator+(float scalar);
		vec3 operator+=(float scalar);
		vec3 operator-(float scalar);
		vec3 operator*(float scalar);
		vec3 operator/(float scalar);
		vec3 operator=(float[4]);
	};

	class mat4 {
	public:
		float m[4][4];

		float max, may, maz, maw,
			mbx, mby, mbz, mbw,
			mcx, mcy, mcz, mcw,
			mdx, mdy, mdz, mdw;

		mat4() {max = may = maz = maw =
				mbx = mby = mbz = mbw =
				mcx = mcy = mcz = mcw =
				mdx = mdy = mdz = mdw = 0;};

		mat4(float max, float may, float maz, float maw,
			float mbx, float mby, float mbz, float mbw,
			float mcx, float mcy, float mcz, float mcw,
			float mdx, float mdy, float mdz, float mdw) {
			m[0][0] = max, m[1][0] = mbx, m[2][0] = mcx, m[3][0] = mdx,
			m[0][1] = may, m[1][1] = mby, m[2][1] = mcy, m[3][1] = mdy,
			m[0][2] = maz, m[1][2] = mbz, m[2][2] = mcz, m[3][2] = mdz,
			m[0][3] = maw, m[1][3] = mbw, m[2][3] = mcw, m[3][3] = mdw;
		};

		mat4 operator*(mat4 rhs);
		mat4 translate(jv::vec3 offset);
		mat4 scale(jv::vec3 scale);
		mat4 rotateX(float radAngle);
		mat4 rotateY(float radAngle);
		mat4 rotateZ(float radAngle);
		mat4 rotate(float radAngle, jv::vec3 axis);
		
	};

	vec3 cross(vec3 lhs, vec3 rhs);
	vec3 normalise(vec3 v);
	float dot(vec3 lhs, vec3 rhs);
	float length(vec3 v);

	mat4 perspective(float vertical_field_of_view_in_deg, float aspect_ratio, float near_view_distance, float far_view_distance);
	mat4 lookAt(vec3 from, vec3 to, vec3 up);
	mat4 inverse(mat4 matrix);
	mat4 identity();

	float radians(float degrees);

	float radians(float degrees) {
		return degrees * M_PI / 180.0f;
	}


	bool vec3::operator==(vec3 rhs) {
		return (x == rhs.x &&
			y == rhs.y &&
			z == rhs.z);
	}

	vec3 vec3::operator+(vec3 rhs) {
		return vec3(x + rhs.x,
			y + rhs.y,
			z + rhs.z);
	}

	vec3 vec3::operator+(float scalar) {
		return vec3(x + scalar,
			y + scalar,
			z + scalar);
	}

	vec3 vec3::operator+=(vec3 rhs) {
		return vec3(x + rhs.x,
			y + rhs.y,
			z + rhs.z);
	}

	vec3 vec3::operator+=(float scalar) {
		return vec3(x + scalar,
			y + scalar,
			z + scalar);
	}

	vec3 vec3::operator-(vec3 rhs) {
		return vec3(x - rhs.x,
			y - rhs.y,
			z - rhs.z);
	}

	vec3 vec3::operator-(float scalar) {
		return vec3(x - scalar,
			y - scalar,
			z - scalar);
	}

	vec3 vec3::operator*(vec3 rhs) {
		return vec3(x * rhs.x,
			y * rhs.y,
			z * rhs.z);
	}

	vec3 vec3::operator*(float scalar) {
		return vec3(x * scalar,
			y * scalar,
			z * scalar);
	}

	vec3 vec3::operator/(vec3 rhs) {
		return vec3(x / rhs.x,
			y / rhs.y,
			z / rhs.z);
	}

	vec3 vec3::operator/(float scalar) {
		return vec3(x / scalar,
			y / scalar,
			z / scalar);
	}

	vec3 vec3::operator=(float f[4]) {
		return vec3(f[0], f[1], f[2]);
	}

	vec3 cross(vec3 lhs, vec3 rhs) {
		return vec3(
			lhs.y * rhs.z - lhs.z * rhs.y,
			lhs.z * rhs.x - lhs.x * rhs.z,
			lhs.x * rhs.y - lhs.y * rhs.x
		);
	}

	float dot(vec3 lhs, vec3 rhs) {
		return lhs.x*rhs.x + lhs.y*rhs.y + lhs.z*rhs.z;
	}

	float length(vec3 v) {
		return sqrtf(v.x*v.x + v.y*v.y + v.z*v.z);
	}

	vec3 normalise(vec3 v) {
		float len = length(v);
		if (len > 0)
			return vec3(v.x / len, v.y / len, v.z / len );
		else
			return vec3( 0, 0, 0 );
	}

	mat4 identity() {
		return mat4(
			1, 0, 0, 0,
			0, 1, 0, 0,
			0, 0, 1, 0,
			0, 0, 0, 1
		);
	}

	mat4 mat4::operator*(mat4 rhs) {
		mat4 result;

		for (int i = 0; i < 4; i++) {
			for (int j = 0; j < 4; j++) {
				float sum = 0;
				for (int k = 0; k < 4; k++) {
					sum += m[k][j] * rhs.m[i][k];
				}
				result.m[i][j] = sum;
			}
		}

		return result;
	}

	mat4 translate(jv::vec3 offset) {
		return mat4(
			1, 0, 0, offset.x,
			0, 1, 0, offset.y,
			0, 0, 1, offset.z,
			0, 0, 0, 1
		);
	}

	mat4 scale(jv::vec3 scale) {
		float x = scale.x, y = scale.y, z = scale.z;

		return mat4(
			x, 0, 0, 0,
			0, y, 0, 0,
			0, 0, z, 0,
			0, 0, 0, 1
		);
	}

	mat4 rotateX(float radAngle) {
		float sin = sinf(radAngle), cos = cosf(radAngle);
		return mat4(
			1, 0, 0, 0
			0, cos, -sin, 0,
			0, sin, cos, 0,
			0, 0, 0, 1
		);
	}

	mat4 rotateY(float radAngle) {
		float sin = sinf(radAngle), cos = cosf(radAngle);
		return mat4(
			cos, 0, sin, 0
			0, 1, 0, 0,
			-sin, 0, cos, 0,
			0, 0, 0, 1
		);
	}

	mat4 rotateZ(float radAngle) {
		float sin = sinf(radAngle), cos = cosf(radAngle);
		return mat4(
			cos, -sin, 0, 0
			sin, cos, 0, 0,
			0, 0, 1, 0,
			0, 0, 0, 1
		);
	}

	mat4 rotate(float radAngle, jv::vec3 axis) {
		jv::vec3 nAxis = jv::normalise(axis);
		float x = nAxis.x, y = nAxis.y, z = nAxis.z;
		float sin = sinf(radAngle), cos = cosf(radAngle);

		return mat4(
			cos + x * x *(1 - c),		x * y * (1 - c) - z * s,	x * z * (1 - c) + y * s, 0,
			y * x * (1 - c) + z * s,	c + y * y * (1 - c),		y * z * (1 - c) - x * s, 0,
			z * x * (1 - c) - y * s,	z * y * (1 - c) + x * s,	c + z * z * (1 - c),	 0,
			0,							0,							0,						 1
		);
	}

	mat4 perspective(float vFov, float aspectR, float nearViewD, float farViewD) {
		float fovy_in_rad = vFov / 180 * M_PI;
		float f = 1.0f / tanf(fovy_in_rad / 2.0f);
		float ar = aspectR;
		float nd = nearViewD, fd = farViewD;

		return mat4(
			f / ar, 0, 0, 0,
			0, f, 0, 0,
			0, 0, (fd + nd) / (nd - fd), (2 * fd*nd) / (nd - fd),
			0, 0, -1, 0
		);
	}

	mat4 lookAt(vec3 from, vec3 to, vec3 up) {
		vec3 z = normalise(to - from) * -1;
		vec3 x = normalise(cross(up, z));
		vec3 y = cross(z, x);

		return mat4(
			x.x, x.y, x.z, -dot(from, x),
			y.x, y.y, y.z, -dot(from, y),
			z.x, z.y, z.z, -dot(from, z),
			0, 0, 0, 1
		);
	}

	mat4 inverse(mat4 matrix) {
		// Create shorthands to access matrix members
		float m00 = matrix.max, m10 = matrix.mbx, m20 = matrix.mcx, m30 = matrix.mdx;
		float m01 = matrix.may, m11 = matrix.mby, m21 = matrix.mcy, m31 = matrix.mdy;
		float m02 = matrix.maz, m12 = matrix.mbz, m22 = matrix.mcz, m32 = matrix.mdz;

		// Invert 3x3 part of the 4x4 matrix that contains the rotation, etc.

		// Calculate determinants from cofactor matrix
		float c00 = m11*m22 - m12*m21, c10 = -(m01*m22 - m02*m21), c20 = m01*m12 - m02*m11;
		float c01 = -(m10*m22 - m12*m20), c11 = m00*m22 - m02*m20, c21 = -(m00*m12 - m02*m10);
		float c02 = m10*m21 - m11*m20, c12 = -(m00*m21 - m01*m20), c22 = m00*m11 - m01*m10;

		// Caclculate the determinant using calculated determinants
		float det = m00*c00 + m10*c10 + m20 * c20;
		if (fabsf(det) < 0.00001)
			return identity();

		// Calcuate inverse by dividing transposed cofactor matrix by the determinant
		float i00 = c00 / det, i10 = c01 / det, i20 = c02 / det;
		float i01 = c10 / det, i11 = c11 / det, i21 = c12 / det;
		float i02 = c20 / det, i12 = c21 / det, i22 = c22 / det;

		// Combine with the inverted translation
		return mat4(
			i00, i10, i20, -(i00*m30 + i10*m31 + i20*m32),
			i01, i11, i21, -(i01*m30 + i11*m31 + i21*m32),
			i02, i12, i22, -(i02*m30 + i12*m31 + i22*m32),
			0, 0, 0, 1
		);
	}
}
#endif